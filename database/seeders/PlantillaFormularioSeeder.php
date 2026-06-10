<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlantillaFormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plantillas = [
            [
                'id' => 1,
                'name' => 'Historia Clínica Nutricional Profesional Azul',
                'version' => '1.0',
                'created_at' => '2026-06-04 21:03:28',
                'updated_at' => '2026-06-04 21:03:28',
                'content_data' => [
                    'version' => '1.0',
                    'plantilla_name' => 'Historia Clínica Nutricional Profesional Azul',
                    'secciones' => [
                        [
                            'id' => 'datos_generales',
                            'titulo' => 'Datos Generales',
                            'campos' => [
                                ['id' => 'nombre', 'type' => 'text', 'label' => 'Nombre Completo', 'required' => true],
                                ['id' => 'fecha_nacimiento', 'type' => 'date', 'label' => 'Fecha de Nacimiento', 'required' => true],
                                ['id' => 'edad', 'type' => 'number', 'label' => 'Edad', 'required' => false],
                                ['id' => 'sexo', 'type' => 'select', 'label' => 'Sexo', 'options' => ['Hombre', 'Mujer', 'Other'], 'required' => false],
                                ['id' => 'estado_civil', 'type' => 'select', 'label' => 'Estado Civil', 'options' => ['Soltero/a', 'Casado/a', 'Divorciado/a', 'Unión Libre', 'Viudo/a'], 'required' => false],
                                ['id' => 'ocupacion', 'type' => 'text', 'label' => 'Ocupación', 'required' => false],
                                ['id' => 'telefono', 'type' => 'tel', 'label' => 'Teléfono', 'required' => false],
                                ['id' => 'direccion', 'type' => 'text', 'label' => 'Dirección', 'required' => false],
                            ]
                        ],
                        [
                            'id' => 'antecedentes_heredofamiliares',
                            'titulo' => 'Antecedentes Heredofamiliares',
                            'campos' => [
                                ['id' => 'hf_diabetes', 'type' => 'checkbox_group', 'label' => 'Diabetes', 'options' => ['Mamá', 'Papá', 'Hermano/a', 'Abuelos', 'Otros familiares']],
                                ['id' => 'hf_cancer', 'type' => 'checkbox_group', 'label' => 'Cáncer', 'options' => ['Mamá', 'Papá', 'Hermano/a', 'Abuelos', 'Otros familiares']],
                                ['id' => 'hf_dislipidemia', 'type' => 'checkbox_group', 'label' => 'Dislipidemia', 'options' => ['Mamá', 'Papá', 'Hermano/a', 'Abuelos', 'Otros familiares']],
                                ['id' => 'hf_anemia', 'type' => 'checkbox_group', 'label' => 'Anemia', 'options' => ['Mamá', 'Papá', 'Hermano/a', 'Abuelos', 'Otros familiares']],
                                ['id' => 'hf_hipertension', 'type' => 'checkbox_group', 'label' => 'Hipertensión arterial', 'options' => ['Mamá', 'Papá', 'Hermano/a', 'Abuelos', 'Otros familiares']],
                                ['id' => 'hf_enfermedades_renales', 'type' => 'checkbox_group', 'label' => 'Enfermedades Renales', 'options' => ['Mamá', 'Papá', 'Hermano/a', 'Abuelos', 'Otros familiares']],
                                ['id' => 'hf_otros', 'type' => 'text', 'label' => 'Otros antecedentes familiares (Especificar)'],
                            ]
                        ],
                        [
                            'id' => 'antecedentes_personales_patologicos',
                            'titulo' => 'Antecedentes Personales Patológicos',
                            'campos' => [
                                ['id' => 'pat_diabetes', 'type' => 'select', 'label' => '¿Padece Diabetes?', 'options' => ['Sí', 'No']],
                                ['id' => 'pat_diabetes_tiempo', 'type' => 'text', 'label' => 'Tiempo desde que fue detectada la Diabetes'],
                                ['id' => 'pat_hipertension', 'type' => 'select', 'label' => '¿Padece Hipertensión arterial?', 'options' => ['Sí', 'No']],
                                ['id' => 'pat_hipertension_tiempo', 'type' => 'text', 'label' => 'Tiempo desde que fue detectada la Hipertensión'],
                                ['id' => 'pat_cancer', 'type' => 'select', 'label' => '¿Padece Cáncer?', 'options' => ['Sí', 'No']],
                                ['id' => 'pat_cancer_tiempo', 'type' => 'text', 'label' => 'Tiempo desde que fue detectado el Cáncer'],
                                ['id' => 'pat_obesidad', 'type' => 'select', 'label' => '¿Padece Obesidad?', 'options' => ['Sí', 'No']],
                                ['id' => 'pat_obesidad_tiempo', 'type' => 'text', 'label' => 'Tiempo desde que fue detectada la Obesidad'],
                                ['id' => 'pat_dislipidemia', 'type' => 'select', 'label' => '¿Padece Dislipidemia?', 'options' => ['Sí', 'No']],
                                ['id' => 'pat_dislipidemia_tiempo', 'type' => 'text', 'label' => 'Tiempo desde que fue detectada la Dislipidemia'],
                                ['id' => 'pat_renales', 'type' => 'select', 'label' => '¿Padece Enfermedades Renales?', 'options' => ['Sí', 'No']],
                                ['id' => 'pat_renales_tiempo', 'type' => 'text', 'label' => 'Tiempo desde que fueron detectadas las Enfermedades Renales'],
                                ['id' => 'pat_anemia', 'type' => 'select', 'label' => '¿Padece Anemia?', 'options' => ['Sí', 'No']],
                                ['id' => 'pat_anemia_tiempo', 'type' => 'text', 'label' => 'Tiempo desde que fue detectada la Anemia'],
                                ['id' => 'pat_cirugias_fracturas', 'type' => 'text', 'label' => 'Cirugías o fracturas (Detalles y fechas)'],
                                ['id' => 'pat_medicamentos_actuales', 'type' => 'text', 'label' => 'Medicamentos actuales / Dosis'],
                                ['id' => 'pat_otros_especificar', 'type' => 'text', 'label' => 'Otros padecimientos personales'],
                            ]
                        ],
                        [
                            'id' => 'antecedentes_personales_no_patologicos',
                            'titulo' => 'Antecedentes Personales No Patológicos',
                            'campos' => [
                                ['id' => 'nopat_ejercicio_deporte', 'type' => 'text', 'label' => '¿Realiza ejercicio o deporte?'],
                                ['id' => 'nopat_ejercicio_frecuencia_horario', 'type' => 'text', 'label' => 'Frecuencia y horario del deporte'],
                                ['id' => 'nopat_toxicomanias', 'type' => 'text', 'label' => 'Toxicomanías'],
                                ['id' => 'nopat_toxicomanias_frecuencia', 'type' => 'text', 'label' => 'Frecuencia de consumo'],
                            ]
                        ],
                        [
                            'id' => 'trastornos_gastrointestinales',
                            'titulo' => 'Trastornos Gastrointestinales',
                            'campos' => [
                                ['id' => 'tg_vomito', 'type' => 'gastro_sintoma', 'label' => 'Vómito', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_reflujo', 'type' => 'gastro_sintoma', 'label' => 'Reflujo', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_diarrea', 'type' => 'gastro_sintoma', 'label' => 'Diarrea', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_flatulencias', 'type' => 'gastro_sintoma', 'label' => 'Flatulencias', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_estrenimiento', 'type' => 'gastro_sintoma', 'label' => 'Estreñimiento', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_colitis', 'type' => 'gastro_sintoma', 'label' => 'Colitis', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_gastritis', 'type' => 'gastro_sintoma', 'label' => 'Gastritis', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_nauseas', 'type' => 'gastro_sintoma', 'label' => 'Náuseas', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_pirosis', 'type' => 'gastro_sintoma', 'label' => 'Pirosis', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_disfagia', 'type' => 'gastro_sintoma', 'label' => 'Disfagia', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                                ['id' => 'tg_distension', 'type' => 'gastro_sintoma', 'label' => 'Distensión', 'sub_campos' => [['id' => 'padece', 'type' => 'select', 'label' => '¿Padece?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Cantidad de días / Frecuencia']]],
                            ]
                        ],
                        [
                            'id' => 'antecedentes_gineco',
                            'titulo' => 'Antecedentes Gineco-Obstétricos (Si aplica)',
                            'campos' => [
                                ['id' => 'g_gravideces', 'type' => 'text', 'label' => 'G (Gestas)'],
                                ['id' => 'p_partos', 'type' => 'text', 'label' => 'P (Partos)'],
                                ['id' => 'c_cesareas', 'type' => 'text', 'label' => 'C (Cesareas)'],
                                ['id' => 'fum', 'type' => 'date', 'label' => 'FUM (Fecha de Última Menstruación)'],
                                ['id' => 'fup_c', 'type' => 'date', 'label' => 'FUP / C (Fecha de Último Parto o Cesárea)'],
                                ['id' => 'sdg', 'type' => 'text', 'label' => 'SDG (Semanas de Gestación)'],
                                ['id' => 'ppg', 'type' => 'text', 'label' => 'PPG'],
                                ['id' => 'anticonceptivos', 'type' => 'text', 'label' => 'Uso de Anticonceptivos (Cuáles y frecuencia)'],
                            ]
                        ],
                        [
                            'id' => 'habitos_alimentacion',
                            'titulo' => 'Hábitos de Alimentación',
                            'campos' => [
                                ['id' => 'con_quien_come', 'type' => 'text', 'label' => '¿Con quién come?'],
                                ['id' => 'quien_prepara_alimentos', 'type' => 'text', 'label' => '¿Quién prepara sus alimentos?'],
                                ['id' => 'comidas_al_dia', 'type' => 'number', 'label' => 'Comidas consumidas en el día'],
                                ['id' => 'hace_colaciones', 'type' => 'select', 'label' => '¿Hace colaciones?', 'options' => ['Sí', 'No']],
                                ['id' => 'colaciones_alimentos', 'type' => 'text', 'label' => '¿Con qué alimentos hace colaciones?'],
                                ['id' => 'horarios_comida', 'type' => 'text', 'label' => 'Horarios habituales de comida'],
                                ['id' => 'comidas_en_casa', 'type' => 'text', 'label' => 'Comidas que realiza en casa'],
                                ['id' => 'comidas_fuera_casa', 'type' => 'text', 'label' => 'Comidas fuera de casa (Entre semana)'],
                                ['id' => 'comidas_fuera_casa_fin_semana', 'type' => 'text', 'label' => 'Comidas fuera de casa (Fines de semana)'],
                                ['id' => 'hora_mayor_apetito', 'type' => 'text', 'label' => 'Hora de mayor apetito en el día'],
                                ['id' => 'consideracion_apetito', 'type' => 'text', 'label' => '¿Cómo considera su apetito y qué cambios nota?'],
                                ['id' => 'suplementos', 'type' => 'text', 'label' => 'Suplementos o vitamins que consume'],
                                ['id' => 'alergias', 'type' => 'text', 'label' => 'Alergias alimentarias'],
                                ['id' => 'alimentos_preferidos', 'type' => 'text', 'label' => 'Alimentos preferidos'],
                                ['id' => 'alimentos_disgustan', 'type' => 'text', 'label' => 'Alimentos que le disgustan'],
                                ['id' => 'intolerancias', 'type' => 'text', 'label' => 'Intolerancias alimentarias'],
                                ['id' => 'dietas_anteriores', 'type' => 'text', 'label' => 'Dietas realizadas anteriormente'],
                                ['id' => 'medicamentos_bajar_peso', 'type' => 'text', 'label' => 'Medicamentos utilizados para bajar de peso'],
                            ]
                        ],
                        [
                            'id' => 'frecuencia_semanal_consumo',
                            'titulo' => 'Frecuencia Semanal de Consumo por Grupos',
                            'campos' => [
                                ['id' => 'f_verduras', 'type' => 'frecuencia_alimento', 'label' => 'Verduras', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_frutas', 'type' => 'frecuencia_alimento', 'label' => 'Frutas', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_cereales_azucarados', 'type' => 'frecuencia_alimento', 'label' => 'Cereales azucarados', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_leguminosas', 'type' => 'frecuencia_alimento', 'label' => 'Leguminosas', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_carne_res', 'type' => 'frecuencia_alimento', 'label' => 'Carne de Res', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_carne_cerdo', 'type' => 'frecuencia_alimento', 'label' => 'Carne de Cerdo', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_carne_pollo_pavo', 'type' => 'frecuencia_alimento', 'label' => 'Carne de Pollo/Pavo', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_pescados_mariscos', 'type' => 'frecuencia_alimento', 'label' => 'Pescados y mariscos', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_huevo', 'type' => 'frecuencia_alimento', 'label' => 'Huevo', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_queso', 'type' => 'frecuencia_alimento', 'label' => 'Queso', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_embutidos', 'type' => 'frecuencia_alimento', 'label' => 'Embutidos', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_leche_yogurt', 'type' => 'frecuencia_alimento', 'label' => 'Leche o yogurt', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_agua', 'type' => 'frecuencia_alimento', 'label' => 'Agua', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_refresco', 'type' => 'frecuencia_alimento', 'label' => 'Refresco', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_te', 'type' => 'frecuencia_alimento', 'label' => 'Té', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_cafe', 'type' => 'frecuencia_alimento', 'label' => 'Café', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_jugos_frutas', 'type' => 'frecuencia_alimento', 'label' => 'Jugos de frutas', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                                ['id' => 'f_colas', 'type' => 'frecuencia_alimento', 'label' => 'Colas', 'sub_campos' => [['id' => 'consume', 'type' => 'select', 'label' => '¿Consume?', 'options' => ['Sí', 'No']], ['id' => 'frecuencia', 'type' => 'text', 'label' => 'Frecuencia semanal']]],
                            ]
                        ],
                        [
                            'id' => 'recordatorio_24_horas',
                            'titulo' => 'Recordatorio de 24 Horas (Menú habitual)',
                            'campos' => [
                                ['id' => 'rec_desayuno', 'type' => 'text', 'label' => 'Desayuno'],
                                ['id' => 'rec_colacion_matutina', 'type' => 'text', 'label' => 'Colación Matutina'],
                                ['id' => 'rec_comida', 'type' => 'text', 'label' => 'Comida'],
                                ['id' => 'rec_colacion_vespertina', 'type' => 'text', 'label' => 'Colación Vespertina'],
                                ['id' => 'rec_cena', 'type' => 'text', 'label' => 'Cena'],
                            ]
                        ],
                        [
                            'id' => 'indicadores_antropometricos',
                            'titulo' => 'Indicadores Antropométricos (Evaluación)',
                            'campos' => [
                                ['id' => 'peso_actual', 'type' => 'number', 'label' => 'Peso Actual (kg)'],
                                ['id' => 'talla', 'type' => 'number', 'label' => 'Talla (m)'],
                                ['id' => 'imc', 'type' => 'calculated', 'label' => 'Índice de Masa Corporal (kg/m²)', 'formula' => 'peso_actual / (talla * talla)'],
                                ['id' => 'perimetro_cadera', 'type' => 'number', 'label' => 'Perímetro de Cadera (cm)'],
                                ['id' => 'peso_habitual', 'type' => 'number', 'label' => 'Peso Habitual (kg)'],
                            ]
                        ],
                        [
                            'id' => 'indicadores_bioquimicos',
                            'titulo' => 'Indicadores Bioquímicos',
                            'campos' => [
                                ['id' => 'bioq_colesterol', 'type' => 'number', 'label' => 'Colesterol (mg/dL)'],
                                ['id' => 'bioq_trigliceridos', 'type' => 'number', 'label' => 'Triglicéridos (mg/dL)'],
                                ['id' => 'bioq_glucosa', 'type' => 'number', 'label' => 'Glucosa (mg/dL)'],
                            ]
                        ],
                        [
                            'id' => 'diagnostico_final',
                            'titulo' => 'Diagnóstico Nutricional',
                            'campos' => [
                                ['id' => 'diagnostico_nutricional', 'type' => 'textarea', 'label' => 'Diagnóstico Nutricional Final'],
                            ]
                        ]
                    ]
                ]
            ],
            [
                'id' => 2,
                'name' => 'Historia Clínica Nutricional Simplificada',
                'version' => '2.0',
                'created_at' => '2026-06-07 19:18:03',
                'updated_at' => '2026-06-07 19:18:03',
                'content_data' => [
                    'version' => '2.0',
                    'plantilla_name' => 'Historia Clínica Nutricional Simplificada',
                    'secciones' => [
                        [
                            'id' => 'datos_generales',
                            'titulo' => 'Datos Generales',
                            'campos' => [
                                ['id' => 'nombre', 'type' => 'text', 'label' => 'Nombre Completo', 'required' => true],
                                ['id' => 'fecha_nacimiento', 'type' => 'date', 'label' => 'Fecha de Nacimiento', 'required' => true],
                                ['id' => 'edad', 'type' => 'number', 'label' => 'Edad', 'required' => false],
                                ['id' => 'sexo', 'type' => 'select', 'label' => 'Sexo', 'options' => ['Hombre', 'Mujer', 'Otros'], 'required' => false],
                                ['id' => 'ocupacion', 'type' => 'text', 'label' => 'Ocupación', 'required' => false],
                                ['id' => 'telefono', 'type' => 'tel', 'label' => 'Teléfono', 'required' => false],
                            ]
                        ],
                        [
                            'id' => 'indicadores_antropometricos',
                            'titulo' => 'Indicadores Antropométricos (Evaluación)',
                            'campos' => [
                                ['id' => 'peso_actual', 'type' => 'number', 'label' => 'Peso Actual (kg)', 'required' => true],
                                ['id' => 'talla', 'type' => 'number', 'label' => 'Talla (m)', 'required' => true],
                                ['id' => 'imc', 'type' => 'calculated', 'label' => 'Índice de Masa Corporal (kg/m²)', 'formula' => 'peso_actual / (talla * talla)', 'required' => false],
                                ['id' => 'peso_habitual', 'type' => 'number', 'label' => 'Peso Habitual (kg)', 'required' => false],
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($plantillas as $plantilla) {

            DB::table('plantilla_formularios')->updateOrInsert(
                ['id' => $plantilla['id']],
                [
                    'name'       => $plantilla['name'],
                    'version'    => $plantilla['version'],
                    'schema'     => json_encode($plantilla['content_data'], JSON_UNESCAPED_UNICODE),
                    'created_at' => $plantilla['created_at'],
                    'updated_at' => $plantilla['updated_at'],
                ]
            );
        }
    }
}
