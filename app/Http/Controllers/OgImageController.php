<?php

namespace App\Http\Controllers;

use App\Services\IdentityService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class OgImageController extends Controller
{
    protected const WIDTH = 1200;

    protected const HEIGHT = 630;

    public function __construct(
        protected IdentityService $identity
    ) {}

    public function __invoke(): Response
    {
        $username = $this->identity->getUsername();
        $cacheKey = "og_image:{$username}";
        $cacheTtl = config('shipforswag.og_image_cache_ttl', 3600);

        $imageData = Cache::remember($cacheKey, $cacheTtl, fn () => $this->generate());

        return response($imageData, 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=3600');
    }

    protected function generate(): string
    {
        $manager = ImageManager::gd();
        $username = $this->identity->getUsername();
        $displayName = $this->identity->getDisplayName();

        // Create base image with clean light background
        $image = $manager->create(self::WIDTH, self::HEIGHT);
        $image->fill('f8fafc'); // slate-50

        // Add subtle top accent bar (Laravel red gradient feel)
        $image->drawRectangle(0, 0, function ($rectangle) {
            $rectangle->size(self::WIDTH, 8);
            $rectangle->background('f53003'); // Laravel red
        });

        // Center everything vertically
        $centerY = self::HEIGHT / 2;

        // Add the avatar
        if ($username) {
            $this->addAvatar($image, $manager, $username, $centerY);
        }

        // Add text content
        $this->addTextContent($image, $displayName, $username, $centerY);

        // Add branding footer
        $this->addBranding($image);

        return $image->toPng()->toString();
    }

    protected function addAvatar(mixed $image, ImageManager $manager, string $username, int $centerY): void
    {
        $avatarUrl = $this->identity->getAvatarUrl(400);
        $avatarSize = 180;
        $avatarX = (self::WIDTH / 2) - ($avatarSize / 2);
        $avatarY = $centerY - 140;

        try {
            $avatarData = Http::timeout(5)->get($avatarUrl)->body();
            $avatar = $manager->read($avatarData);
            $avatar->cover($avatarSize, $avatarSize);

            // Create circular avatar using GD directly
            $circularAvatar = $this->makeCircular($avatar, $avatarSize);

            // Draw shadow/border circle first
            $image->drawCircle((int) ($avatarX + $avatarSize / 2), (int) ($avatarY + $avatarSize / 2), function ($circle) use ($avatarSize) {
                $circle->radius(($avatarSize / 2) + 4);
                $circle->background('e2e8f0'); // slate-200 border
            });

            // Place the circular avatar
            $image->place($circularAvatar, 'top-left', (int) $avatarX, (int) $avatarY);

        } catch (\Throwable) {
            $this->addPlaceholderAvatar($image, $username, $avatarX, $avatarY, $avatarSize);
        }
    }

    protected function makeCircular(mixed $avatar, int $size): mixed
    {
        // Get the GD resource from the avatar
        $avatarCore = $avatar->core()->native();

        // Create a new true color image with transparency
        $circular = imagecreatetruecolor($size, $size);
        imagesavealpha($circular, true);

        // Fill with transparent background
        $transparent = imagecolorallocatealpha($circular, 0, 0, 0, 127);
        imagefill($circular, 0, 0, $transparent);

        // Create circular mask and copy avatar through it
        $centerX = $size / 2;
        $centerY = $size / 2;
        $radius = $size / 2;

        for ($x = 0; $x < $size; $x++) {
            for ($y = 0; $y < $size; $y++) {
                $dx = $x - $centerX;
                $dy = $y - $centerY;
                if (($dx * $dx + $dy * $dy) <= ($radius * $radius)) {
                    $color = imagecolorat($avatarCore, $x, $y);
                    imagesetpixel($circular, $x, $y, $color);
                }
            }
        }

        // Convert back to Intervention Image
        return ImageManager::gd()->read($circular);
    }

    protected function addPlaceholderAvatar(mixed $image, string $username, float $x, float $y, int $size): void
    {
        $centerX = $x + $size / 2;
        $centerY = $y + $size / 2;

        $image->drawCircle((int) $centerX, (int) $centerY, function ($circle) use ($size) {
            $circle->radius($size / 2);
            $circle->background('f53003'); // Laravel red
        });

        // Add first letter of username
        $initial = strtoupper(substr($username, 0, 1));
        $image->text($initial, (int) $centerX, (int) $centerY, function (FontFactory $font) {
            $font->size(72);
            $font->color('ffffff');
            $font->align('center');
            $font->valign('middle');
        });
    }

    protected function addTextContent(mixed $image, ?string $displayName, ?string $username, int $centerY): void
    {
        $textCenterX = self::WIDTH / 2;
        $textY = $centerY + 80;

        // Main headline - clean and bold
        $headline = $displayName ? "{$displayName} shipped!" : 'You shipped!';
        $image->text($headline, (int) $textCenterX, $textY, function (FontFactory $font) {
            $font->size(48);
            $font->color('0f172a'); // slate-900
            $font->align('center');
            $font->valign('middle');
        });

        // Username handle
        if ($username) {
            $image->text("@{$username}", (int) $textCenterX, $textY + 55, function (FontFactory $font) {
                $font->size(24);
                $font->color('64748b'); // slate-500
                $font->align('center');
                $font->valign('middle');
            });
        }
    }

    protected function addBranding(mixed $image): void
    {
        // Laravel Cloud branding at bottom
        $image->text('Deployed on Laravel Cloud', (int) (self::WIDTH / 2), self::HEIGHT - 50, function (FontFactory $font) {
            $font->size(18);
            $font->color('94a3b8'); // slate-400
            $font->align('center');
            $font->valign('middle');
        });
    }
}
