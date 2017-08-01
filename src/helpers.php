<?php

function banner_image($url)
{
    if (! filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
        $url = config('app.url') . $url;
    }

    return image($url, [
        'width' => 1000,
        'height' => 450
    ]);
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

function image($url = '', $options = [])
{
    $proxy = config('francken.images.type');
    $server = config('francken.images.url');

    $options = array_merge(['crop' => '1'], $options);

    switch ($proxy) {
        case 'imaginary': {
            $additional = isset($options['vertical-offset']) && $options['vertical-offset'] != '' ? '&gravity=north' : '';
            return sprintf(
                '%s/resize?width=%d&height=%d&url=%s%s',
                $server,
                $options['width'],
                $options['height'],
                $url,
                $additional
            );
        }
        case 'weserv': {
            $map = [
                'width' => 'w=',
                'height' => 'h=',
            ];

            $addiontals = [];
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
                '%s/upload/q_75,%s,o_webp/%s',
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
