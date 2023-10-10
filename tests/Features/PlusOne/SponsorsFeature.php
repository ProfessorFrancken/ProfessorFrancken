<?php

declare(strict_types=1);

namespace Francken\Features\PlusOne;

use Francken\Extern\Partner;
use Francken\Extern\SponsorOptions\FccFooter;
use Francken\Features\TestCase;
use Francken\PlusOne\Http\SponsorsController;
use Francken\PlusOne\JwtToken;

class SponsorsFeature extends TestCase
{
    /** @test */
    public function it_returns_active_sponsors_of_the_consumption_counter() : void
    {
        $token = new JwtToken(config('francken.plus_one.key'));

        $scriptcie = factory(FccFooter::class)->create([
            'partner_id' => factory(Partner::class)->create([
                'name' => 'S[ck]rip(t|t?c)ie In[ck]'
            ])->id,
            'is_enabled' => true,
        ]);

        $compucie = factory(FccFooter::class)->create([
            'partner_id' => factory(Partner::class)->create([
                'name' => 'Compucie'
            ])->id,
            'is_enabled' => true,
        ]);

        factory(FccFooter::class)->create([
            'partner_id' => factory(Partner::class)->create([
                'name' => 'Borrelcie'
            ])->id,
            'is_enabled' => false,
        ]);

        $this->json('GET', action([SponsorsController::class, 'index']), [], ['Authorization' => 'Bearer ' . $token->token()->toString()])
             ->seeJsonStructure([
                 'sponsors' => [[
                    'name',
                    'image'
                ]],
            ])->receiveJson(['sponsors' => [
                [
                    'name' => $scriptcie->partner->name,
                    'image' => $this->image($scriptcie->logo),
                ],
                [
                    'name' => $compucie->partner->name,
                    'image' => $this->image($compucie->logo),
                ],
            ]]);
    }

    private function image(string $url) : string
    {
        return image($url, ['width' => 300, 'height' => 300]);
    }
}
