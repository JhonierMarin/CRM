<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'   => ['nullable','string','max:120'],
            'edad'     => ['required','integer','min:0','max:120'],
            'genero'   => ['nullable','in:masculino,femenino,otro'],
            'peso'     => ['nullable','numeric','min:0'],
            'altura'   => ['nullable','numeric','min:0'],
            'sintomas' => ['nullable','array'],
            'valores'  => ['nullable','array'],
        ]);

        $nivel = 'bajo';
        $resultado = 'Sin criterios de alerta';

        if (!empty($data['peso']) && !empty($data['altura']) && $data['altura'] > 0) {
            $imc = $data['peso'] / pow($data['altura']/100, 2);
            if ($imc >= 30) { $nivel='medio'; $resultado='Riesgo por IMC alto'; }
        }
        $sintomas = $data['sintomas'] ?? [];
        if (in_array('fiebre',$sintomas) && in_array('dificultad_respiratoria',$sintomas)) {
            $nivel='alto'; $resultado='Posible cuadro respiratorio severo';
        }
        $valores = $data['valores'] ?? [];
        if (isset($valores['glucosa']) && $valores['glucosa'] >= 180) {
            $nivel='alto'; $resultado='Hiperglucemia (sugiere evaluación)';
        }

        $registro = Diagnostico::create([
            'nombre'    => $data['nombre'] ?? null,
            'edad'      => $data['edad'],
            'genero'    => $data['genero'] ?? null,
            'entrada'   => $request->all(),
            'resultado' => $resultado,
            'nivel'     => $nivel,
        ]);

        return response()->json([
            'ok' => true,
            'diagnostico' => ['id'=>$registro->id, 'resultado'=>$resultado, 'nivel'=>$nivel],
        ], 201);
    }
}
