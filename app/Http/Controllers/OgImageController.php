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

    /**
     * Generate the OG image PNG data.
     */
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
            $rectangle->size(self::WIDTH, 12);
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

    /**
     * Add the user's avatar to the image (left side, centered with text).
     */
    protected function addAvatar(mixed $image, ImageManager $manager, string $username, int $centerY): void
    {
        $avatarUrl = $this->identity->getAvatarUrl(400);
        $avatarSize = 320;
        $avatarX = 160; // Centered composition
        $avatarY = $centerY - ($avatarSize / 2);

        try {
            $avatarData = Http::timeout(5)->get($avatarUrl)->body();
            $avatar = $manager->read($avatarData);
            $avatar->cover($avatarSize, $avatarSize);

            // Create circular avatar using GD directly
            $circularAvatar = $this->makeCircular($avatar, $avatarSize);

            // Draw shadow/border circle first
            $image->drawCircle((int) ($avatarX + $avatarSize / 2), (int) ($avatarY + $avatarSize / 2), function ($circle) use ($avatarSize) {
                $circle->radius(($avatarSize / 2) + 6);
                $circle->background('e2e8f0'); // slate-200 border
            });

            // Place the circular avatar
            $image->place($circularAvatar, 'top-left', (int) $avatarX, (int) $avatarY);

        } catch (\Throwable) {
            $this->addPlaceholderAvatar($image, $username, $avatarX, $avatarY, $avatarSize);
        }
    }

    /**
     * Create a circular version of the avatar using GD.
     */
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

    /**
     * Add a placeholder avatar when the real one cannot be loaded.
     */
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
        $fontBold = resource_path('fonts/InstrumentSans-Bold.ttf');
        $image->text($initial, (int) $centerX, (int) $centerY, function (FontFactory $font) use ($fontBold) {
            $font->filename($fontBold);
            $font->size(140);
            $font->color('ffffff');
            $font->align('center');
            $font->valign('middle');
        });
    }

    /**
     * Add the text content (right side of image, centered with avatar).
     */
    protected function addTextContent(mixed $image, ?string $displayName, ?string $username, int $centerY): void
    {
        $textX = 530; // Aligned with centered composition
        $textY = $centerY - 60;
        $fontBold = resource_path('fonts/InstrumentSans-Bold.ttf');
        $fontRegular = resource_path('fonts/InstrumentSans-Regular.ttf');

        // Main headline - large and bold
        $headline = $displayName ? "{$displayName}" : 'You';
        $image->text($headline, $textX, $textY, function (FontFactory $font) use ($fontBold) {
            $font->filename($fontBold);
            $font->size(68);
            $font->color('0f172a'); // slate-900
            $font->align('left');
            $font->valign('middle');
        });

        // "shipped!" on second line - tighter spacing
        $image->text('shipped!', $textX, $textY + 70, function (FontFactory $font) use ($fontBold) {
            $font->filename($fontBold);
            $font->size(68);
            $font->color('f53003'); // Laravel red
            $font->align('left');
            $font->valign('middle');
        });

        // Username handle - tighter spacing
        if ($username) {
            $image->text("@{$username}", $textX, $textY + 130, function (FontFactory $font) use ($fontRegular) {
                $font->filename($fontRegular);
                $font->size(32);
                $font->color('64748b'); // slate-500
                $font->align('left');
                $font->valign('middle');
            });
        }
    }

    /**
     * Add the Laravel Cloud branding footer.
     */
    protected function addBranding(mixed $image): void
    {
        $fontRegular = resource_path('fonts/InstrumentSans-Regular.ttf');

        // Laravel Cloud branding at bottom right
        $image->text('Deployed on Laravel Cloud', self::WIDTH - 60, self::HEIGHT - 35, function (FontFactory $font) use ($fontRegular) {
            $font->filename($fontRegular);
            $font->size(20);
            $font->color('94a3b8'); // slate-400
            $font->align('right');
            $font->valign('middle');
        });
    }
}
