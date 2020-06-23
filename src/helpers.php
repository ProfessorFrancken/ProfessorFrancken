<?php

declare(strict_types=1);

function banner_image($url, $options)
{
    if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
        $url = config('app.url') . $url;
    }

    return image($url, array_merge($options, [
        'width' => 1000,
        'height' => 450
    ]));
}

function board_banner_image($url = '', $options = [])
{
    return image($url, array_merge($options, [
        'width' => 930,
        'height' => 350
    ]));
}

function board_full_image($url)
{
    return image($url, [
        'width' => 1600,
        'height' => 900
    ]);
}

function board_member_image($url, $number)
{
    return image($url, [
        'width' => 300,
        'height' => 300,
        'face' => $number
    ]);
}

function news_image($url)
{
    if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
        $url = config('app.url') . $url;
    }


    return image($url, [
        'width' => 600,
        'height' => 600,
    ]);
}

function image($url = '', $options = [], $addAppUrl = false)
{
    if ($addAppUrl && ! filter_var($url, FILTER_VALIDATE_URL)) {
        $url = config('app.url') . $url;
    }

    $proxy = config('francken.images.type');
    $server = config('francken.images.url');

    $options = array_merge(['crop' => '1'], $options);

    $proxy = 'imaginary';
    //   $server = 'https://images.scriptcie.nl';
    // return $url;
    switch ($proxy) {
        case 'imaginary': {

            $additional = isset($options['vertical-offset']) && $options['vertical-offset'] != ''
                ? '&gravity=north'
                : '';

            // background, sign, gravity,
            return sprintf(
                '%s/crop?extend=background,background=250,250,250&width=%d&height=%d%s&url=%s',
                $server,
                $options['width'],
                $options['height'],
                $additional,
                $url
            );
        }
        case 'weserv': {
            $map = [
                'width' => 'w=',
                'height' => 'h=',
            ];

            $additionals = [];
            foreach ($options as $option => $value) {
                if (isset($map[$option])) {
                    $additionals[$map[$option]] = $value;
                }
            }
            $result = [];
            foreach ($additionals as $additional => $value) {
                $result[] = $additional . $value;
            }

            return sprintf(
                '%s/%s&url=%s',
                $server,
                implode($result, ','),
                $url
            );
        }
        case 'fly': {
            $map = [
                'width' => 'w_',
                'height' => 'h_',
                'face' => 'fc_1,fcp_',
                'crop' => 'c_',
                'vertical-offset' => 'g_'
            ];

            $additionals = [];
            foreach ($options as $option => $value) {
                if (isset($map[$option])) {
                    $additionals[$map[$option]] = $value;
                }
            }

            $result = [];
            foreach ($additionals as $additional => $value) {
                $result[] = $additional . $value;
            }

            return sprintf(
                '%s/upload/q_75,%s/%s',
                $server,
                implode($result, ','),
                $url
            );
        }
        default: {
            return $url;
        }
    }
}
