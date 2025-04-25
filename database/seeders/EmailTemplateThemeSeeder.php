<?php

namespace Database\Seeders;

use Visualbuilder\EmailTemplates\Models\EmailTemplateTheme;
use Illuminate\Database\Seeder;

class EmailTemplateThemeSeeder extends Seeder
{
    public function run() {
        $themes = [
            [
            'name'       => 'Modern Bold',
            'colours'=>[
                'header_bg_color'    => '#2196F3', // Blue 500
                'content_bg_color'   => '#FFFFFF', // White

                'body_bg_color'      => '#F5F5F5', // Grey 100
                'body_color'         => '#212121', // Grey 900

                'footer_bg_color'    => '#1A237E', // Indigo 900
                'footer_color'       => '#FFFFFF', // White

                'callout_bg_color'   => '#FFC107', // Amber 500
                'callout_color'      => '#212121', // Grey 900

                'button_bg_color'    => '#FFC107', // Amber 500
                'button_color'       => '#212121', // Grey 900

                'anchor_color'       => '#1976D2', // Blue 700
            ],
            'is_default'=>1,
            ],
            [
            'name'       => 'Pastel',
            'colours'=>[
                'header_bg_color'    => '#CE93D8', // Purple 200
                'body_bg_color'      => '#F5F5F5', // Grey 100
                'content_bg_color'   => '#FFFFFF', // White
                'footer_bg_color'    => '#AB47BC', // Purple 400

                'callout_bg_color'   => '#FFCC80', // Orange 200
                'button_bg_color'    => '#FFAB40', // Orange 300

                // Text Colours
                'body_color'         => '#212121', // Grey 900
                'callout_color'      => '#000000', // Black
                'button_color'       => '#212121', // Grey 900
                'anchor_color'       => '#8E24AA', // Purple 600
            ],
            'is_default'=>0,
            ],
            [
            'name'       => 'Elegant Contrast',
            'colours'=>[
                'header_bg_color'    => '#673AB7', // Deep Purple 500
                'body_bg_color'      => '#F5F5F5', // Grey 100
                'content_bg_color'   => '#FFFFFF', // White
                'footer_bg_color'    => '#4527A0', // Deep Purple 700

                'callout_bg_color'   => '#E91E63', // Pink 500
                'button_bg_color'    => '#FFEB3B', // Yellow 500

                'body_color'         => '#212121', // Grey 900
                'callout_color'      => '#FFFFFF', // White
                'button_color'       => '#212121', // Grey 900
                'anchor_color'       => '#673AB7', // Deep Purple 500
            ],
            'is_default'=>0,
            ],
            [
            'name'       => 'Earthy & Calm',
            'colours'=>[
                'header_bg_color'    => '#4CAF50', // Green 500
                'body_bg_color'      => '#F5F5F5', // Grey 100
                'content_bg_color'   => '#FFFFFF', // White
                'footer_bg_color'    => '#2E7D32', // Green 800

                'callout_bg_color'   => '#FF7043', // Deep Orange 400
                'button_bg_color'    => '#FFEB3B', // Yellow 500

                'body_color'         => '#212121', // Grey 900
                'callout_color'      => '#212121', // Grey 900
                'button_color'       => '#212121', // Grey 900
                'anchor_color'       => '#4CAF50', // Green 500
            ],
            'is_default'=>0,
            ],
        ];

        EmailTemplateTheme::factory()
            ->createMany($themes);
    }
}
