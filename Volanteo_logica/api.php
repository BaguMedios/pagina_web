    <?php
    header('Content-Type: application/json');

    // Obtener la localidad y el número de volanteadores desde la URL
    $localidad = isset($_GET['localidad']) ? mb_strtolower(trim($_GET['localidad'])) : '';
    $volanteadores = isset($_GET['volanteadores']) ? intval($_GET['volanteadores']) : 1;

    // Datos ficticios base para cada localidad de Bogotá
    $data = [
        "localidad usaquén" => [
            "base_efectividad" => 80,
            "base_volantes" => 220,
            "descripcion" => "Zona residencial y comercial de alto nivel en el norte de Bogotá."
        ],
        "localidad chapinero" => [
            "base_efectividad" => 75,
            "base_volantes" => 210,
            "descripcion" => "Sector vibrante y diverso con amplia oferta cultural y comercial."
        ],
        "localidad santa fe" => [
            "base_efectividad" => 70,
            "base_volantes" => 200,
            "descripcion" => "Área central con alta concentración de oficinas y comercio."
        ],
        "localidad san cristóbal" => [
            "base_efectividad" => 60,
            "base_volantes" => 180,
            "descripcion" => "Zona con crecimiento urbano y comunidades tradicionales."
        ],
        "localidad usme" => [
            "base_efectividad" => 55,
            "base_volantes" => 170,
            "descripcion" => "Sector periférico con áreas residenciales y comercios locales."
        ],
        "localidad tunjuelito" => [
            "base_efectividad" => 50,
            "base_volantes" => 160,
            "descripcion" => "Zona en constante cambio demográfico y actividad local."
        ],
        "localidad bosa" => [
            "base_efectividad" => 45,
            "base_volantes" => 150,
            "descripcion" => "Área con alta densidad poblacional y comercio local activo."
        ],
        "localidad kennedy" => [
            "base_efectividad" => 65,
            "base_volantes" => 190,
            "descripcion" => "Localidad amplia con grandes centros comerciales y residenciales."
        ],
        "localidad fontibón" => [
            "base_efectividad" => 60,
            "base_volantes" => 185,
            "descripcion" => "Zona industrial y residencial con considerable tránsito."
        ],
        "localidad engativá" => [
            "base_efectividad" => 80,
            "base_volantes" => 220,
            "descripcion" => "Área con alto tránsito y actividad comercial en el occidente de Bogotá."
        ],
        "localidad suba" => [
            "base_efectividad" => 70,
            "base_volantes" => 210,
            "descripcion" => "Localidad con gran densidad poblacional y variedad de centros comerciales."
        ],
        "localidad barrios unidos" => [
            "base_efectividad" => 65,
            "base_volantes" => 200,
            "descripcion" => "Sector céntrico con una mezcla de zonas residenciales y comerciales."
        ],
        "localidad teusaquillo" => [
            "base_efectividad" => 70,
            "base_volantes" => 205,
            "descripcion" => "Zona histórica y cultural con alta presencia estudiantil."
        ],
        "localidad los mártires" => [
            "base_efectividad" => 55,
            "base_volantes" => 175,
            "descripcion" => "Área con diversidad cultural y desafíos en infraestructura."
        ],
        "localidad antonio nariño" => [
            "base_efectividad" => 60,
            "base_volantes" => 180,
            "descripcion" => "Sector en crecimiento demográfico y actividad local moderada."
        ],
        "localidad puente aranda" => [
            "base_efectividad" => 50,
            "base_volantes" => 160,
            "descripcion" => "Zona con una combinación de áreas industriales y residenciales."
        ],
        "localidad la candelaria" => [
            "base_efectividad" => 75,
            "base_volantes" => 200,
            "descripcion" => "Centro histórico con fuerte presencia turística y cultural."
        ],
        "localidad rafael uribe uribe" => [
            "base_efectividad" => 55,
            "base_volantes" => 170,
            "descripcion" => "Área con comunidades tradicionales y desarrollo urbano moderado."
        ],
        "localidad ciudad bolívar" => [
            "base_efectividad" => 45,
            "base_volantes" => 150,
            "descripcion" => "Zona con alta densidad poblacional y retos en infraestructura."
        ],
        "localidad sumapaz" => [
            "base_efectividad" => 40,
            "base_volantes" => 140,
            "descripcion" => "Extensa área rural con baja concentración poblacional."
        ]
    ];

    // Verificar si la localidad existe en nuestros datos
    if (array_key_exists($localidad, $data)) {
        $base = $data[$localidad];
        
        // Ajuste de efectividad: aumentamos en 5% por cada volanteador adicional (máximo 100%)
        $efectividad = min($base["base_efectividad"] + ($volanteadores - 1) * 2, 100);
        
        // Ajuste de volantes: reducimos 10 unidades por cada volanteador adicional (sin bajar de 50)
        $volantes_recomendados = max($base["base_volantes"] + ($volanteadores + 1) * 19, 50);
        
        echo json_encode([
            "localidad" => ucfirst($localidad),
            "data" => [
                "efectividad" => $efectividad,
                "volantes_recomendados" => $volantes_recomendados,
                "descripcion" => $base["descripcion"]
            ]
        ]);
    } else {
        echo json_encode([
            "error" => "Localidad no encontrada o no especificada"
        ]);
    }
    ?>
