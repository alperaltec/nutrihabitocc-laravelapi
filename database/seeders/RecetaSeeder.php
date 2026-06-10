<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recetas = [
            [
                'id' => 1,
                'name' => 'Ensalada de Pollo y Aguacate Alta en Proteínas',
                'description' => 'Una opción fresca, rápida y cargada de grasas saludables y proteínas magras.',
                'ingredients' => [
                    '150g de pechuga de pollo a la plancha en cubos',
                    'Medio aguacate maduro en rodajas',
                    '2 tazas de lechuga romana picada',
                    '1/2 taza de tomates cherry cortados por la mitad',
                    '1 cucharada de aceite de oliva extra virgen',
                    'Sal y pimienta al gusto'
                ],
                'instructions' => [
                    'En un tazón grande, coloca la cama de lechuga romana limpia.',
                    'Agrega los tomates cherry y los cubos de pechuga de pollo.',
                    'Coloca las rodajas de aguacate en la parte superior.',
                    'Adereza con el aceite de oliva, sal y pimienta antes de servir.'
                ],
                'portions' => 1,
                'is_active' => true,
                'created_at' => '2026-06-09 12:00:00',
                'updated_at' => '2026-06-09 12:00:00',
            ],
            [
                'id' => 2,
                'name' => 'Avena Trasnochada (Overnight Oats) con Chía y Berries',
                'description' => 'Desayuno ideal para dejar preparado desde la noche anterior, alto en fibra.',
                'ingredients' => [
                    '1/2 taza de avena en hojuelas',
                    '3/4 de taza de leche almendras o descremada',
                    '1 cucharada de semillas de chía',
                    '1/4 de taza de arándanos frescos',
                    '1 cucharadita de esencia de vainilla',
                    'Canela en polvo al gusto'
                ],
                'instructions' => [
                    'En un frasco de vidrio, mezcla la avena, las semillas de chía, la leche y la vainilla.',
                    'Agrega los arándanos en la parte superior y espolvorea la canela.',
                    'Cierra el frasco y refrigera durante un mínimo de 6 horas o toda la noche.'
                ],
                'portions' => 1,
                'is_active' => true,
                'created_at' => '2026-06-09 12:00:00',
                'updated_at' => '2026-06-09 12:00:00',
            ],
            [
                'id' => 3,
                'name' => 'Filete de Salmón al Horno con Espárragos',
                'description' => 'Cena premium rica en Omega-3 esenciales y micronutrientes.',
                'ingredients' => [
                    '1 filete de salmón fresco (200g)',
                    '1 taza de espárragos trigueros limpios',
                    '1/2 limón (en rodajas y jugo)',
                    '1 diente de ajo picado finamente',
                    '1 cucharadita de romero fresco',
                    '1 cucharadita de aceite de oliva'
                ],
                'instructions' => [
                    'Precalienta el horno a 200°C.',
                    'En una bandeja para horno, coloca el salmón y los espárragos.',
                    'Baña con el aceite de oliva, el jugo de limón, el ajo picado y el romero.',
                    'Hornea durante 12-15 minutos hasta que el salmón esté tierno.'
                ],
                'portions' => 1,
                'is_active' => true,
                'created_at' => '2026-06-09 12:00:00',
                'updated_at' => '2026-06-09 12:00:00',
            ],
            [
                'id' => 4,
                'name' => 'Bowl de Quinoa, Garbanzos y Vegetales Asados',
                'description' => 'Excelente alternativa vegetariana con carbohidratos complejos de bajo índice glucémico.',
                'ingredients' => [
                    '1/2 taza de quinoa cocida',
                    '1/2 taza de garbanzos cocidos',
                    '1/2 taza de brócoli en ramilletes',
                    '1/2 taza de zanahoria en rodajas',
                    '1 cucharadita de pimentón dulce o paprika',
                    '1 cucharada de aderezo de tahini'
                ],
                'instructions' => [
                    'Asa el brócoli y la zanahoria al horno con un toque de sal y paprika durante 20 minutos.',
                    'En un bowl mediano, monta secciones separadas con la quinoa, los garbanzos y los vegetales asados.',
                    'Baña la superficie con la cucharada de aderezo de tahini.'
                ],
                'portions' => 1,
                'is_active' => true,
                'created_at' => '2026-06-09 12:00:00',
                'updated_at' => '2026-06-09 12:00:00',
            ],
            [
                'id' => 5,
                'name' => 'Tortilla de Claras con Espinacas y Queso Ricotta',
                'description' => 'Desayuno o cena ligera, ultra baja en calorías y óptima para control de peso.',
                'ingredients' => [
                    '4 claras de huevo',
                    '1 taza de espinacas tiernas frescas',
                    '2 cucharadas de queso ricotta bajo en grasa',
                    '1/4 de cebolla blanca picada en cubos',
                    'Un toque de spray para cocinar antiadherente'
                ],
                'instructions' => [
                    'En una sartén caliente con spray antiadherente, sofríe la cebolla y las espinacas hasta que reduzcan.',
                    'Bate las claras de huevo con un toque de sal y viértelas en la sartén.',
                    'Cocina a fuego bajo por 3 minutos, añade el queso ricotta en el centro y dobla la tortilla por la mitad.',
                    'Cocina 1 minuto más por lado hasta que esté firme.'
                ],
                'portions' => 1,
                'is_active' => true,
                'created_at' => '2026-06-09 12:00:00',
                'updated_at' => '2026-06-09 12:00:00',
            ]
        ];

        foreach ($recetas as $receta) {
            DB::table('recetas')->updateOrInsert(
                ['id' => $receta['id']],
                [
                    'name'        => $receta['name'],
                    'calorias'    => $receta['calorias'],
                    'is_active'   => $receta['is_active'],
                    'informacion' => json_encode($receta['informacion'], JSON_UNESCAPED_UNICODE),
                    'created_at'  => $receta['created_at'],
                    'updated_at'  => $receta['updated_at'],
                ]
            );
        }
    }
}
