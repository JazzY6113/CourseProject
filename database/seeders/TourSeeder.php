<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\TourImage;
use Illuminate\Support\Str;

class TourSeeder extends Seeder
{
    public function run()
    {
        $tours = [
            [
                'title' => 'Тур "Марс на Алтае"',
                'short_description' => 'В Кош-Агачском районе республики Алтай есть свой собственный Марс — и не один, а целых три. Необычные цветные горы с неофициальными названиями «Марс-1», «Марс-2» и «Марс-3» находятся в 5–7 километрах от Чуйского тракта в долинах рек Кызыл-Чин и Чаган-Узу.',
                'full_description' => 'Этот тур предлагает уникальную возможность познакомиться с красотами Горного Алтая. Вы посетите живописные горные перевалы, кристально чистые озера и познакомитесь с культурой местных народов.',
                'base_price' => 25000.00,
                'duration_days' => 7,
                'max_group_size' => 15,
                'min_group_size' => 6,
                'included' => json_encode([
                    'Проживание в комфортабельных отелях',
                    'Трехразовое питание',
                    'Услуги гида-экскурсовода',
                    'Трансферы по маршруту',
                    'Входные билеты в парки'
                ]),
                'not_included' => json_encode([
                    'Авиабилеты',
                    'Личные расходы',
                    'Алкогольные напитки'
                ]),
                'requirements' => json_encode([
                    'Спортивная форма',
                    'Теплая одежда',
                    'Удобная обувь для ходьбы'
                ]),
                'is_active' => true,
                'is_hot' => true,
                'booking_deadline_days' => 10,
            ],
            [
                'title' => 'Тур "Горы Алтая"',
                'short_description' => 'Прогуляетесь по местам силы Алтая, в уединении с близкими людьми или с самим собой. Пройдёте по мосту на самом глубоком месте реки Катунь, поднимитесь к смотровой площадке и посетите долину горных духов, где сможете услышать, как с вами говорит природа.',
                'full_description' => 'Посетите знаменитые Телецкое озеро, водопады Корбу и множество других природных достопримечательностей. Идеальный тур для любителей природы и фотографии.',
                'base_price' => 18000.00,
                'duration_days' => 5,
                'max_group_size' => 12,
                'min_group_size' => 4,
                'included' => json_encode([
                    'Проживание в гостевых домах',
                    'Питание по программе',
                    'Услуги гида',
                    'Все трансферы',
                    'Экологические сборы'
                ]),
                'not_included' => json_encode([
                    'Дополнительные экскурсии',
                    'Сувениры',
                    'Страховка'
                ]),
                'requirements' => json_encode([
                    'Возраст от 12 лет',
                    'Отсутствие медицинских противопоказаний'
                ]),
                'is_active' => true,
                'is_hot' => false,
                'booking_deadline_days' => 7,
            ],
            [
                'title' => 'Тур "В долину Чулышман Урочищу Ак-Курум"',
                'short_description' => 'Насладитесь красотами хвойных лесов и ощутите силу полноводных рек. Прокатитесь по самым живописным перевалам, поднявшись на высоту горных массивов и почувствуете дуновение свежего ветра и лучи солнца. Увидите величие гор и каскады водопадов.',
                'full_description' => 'Для настоящих любителей экстрима и горных восхождений. Профессиональные гиды, специальное снаряжение и незабываемые впечатления от покорения вершин.',
                'base_price' => 35000.00,
                'duration_days' => 10,
                'max_group_size' => 8,
                'min_group_size' => 3,
                'included' => json_encode([
                    'Специальное снаряжение',
                    'Проживание в палатках',
                    'Питание',
                    'Услуги горного гида',
                    'Страховка'
                ]),
                'not_included' => json_encode([
                    'Личное снаряжение',
                    'Авиабилеты',
                    'Виза (для иностранцев)'
                ]),
                'requirements' => json_encode([
                    'Опыт горных походов',
                    'Медицинская справка',
                    'Спортивная подготовка'
                ]),
                'is_active' => true,
                'is_hot' => true,
                'booking_deadline_days' => 14,
            ],
        ];

        foreach ($tours as $tourData) {
            $tourData['slug'] = Str::slug($tourData['title']);

            $tour = Tour::firstOrCreate(
                ['slug' => $tourData['slug']],
                $tourData
            );

            $this->createTourImages($tour);
        }

        echo "Созданы туры:\n";
        $createdTours = Tour::all();
        foreach ($createdTours as $tour) {
            echo "- {$tour->title} ({$tour->base_price} руб.)\n";
        }
    }

    private function createTourImages($tour)
    {
        $images = [
            [
                'image_path' => 'tour-images/default-tour-1.jpg',
                'alt_text' => $tour->title,
                'order_index' => 0,
                'is_main' => true,
            ],
            [
                'image_path' => 'tour-images/default-tour-2.jpg',
                'alt_text' => $tour->title,
                'order_index' => 1,
                'is_main' => false,
            ],
        ];

        foreach ($images as $imageData) {
            TourImage::firstOrCreate(
                [
                    'tour_id' => $tour->id,
                    'image_path' => $imageData['image_path']
                ],
                $imageData
            );
        }
    }
}
