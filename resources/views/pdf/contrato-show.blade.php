<!DOCTYPE html>
<html>
<head>
    <title>Detalle de Contrato</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
        }
        h1, h2 {
            font-size: 18pt;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
        }
        .comments-section {
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .comment {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
        }
        .comment-meta {
            font-size: 10pt;
            color: #666;
            margin-bottom: 5px;
        }
        .comment-content p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <h1>Detalle del Contrato #{{ $record->id }}</h1>
    
    <div class="detail-row">
        <span class="label">Titular:</span>
        <span>{{ $record->nombre_titular }}</span>
    </div>
    
    <div class="detail-row">
        <span class="label">CUPS:</span>
        <span>{{ substr($record->cups, -6) }}</span>
    </div>
    
    <div class="detail-row">
        <span class="label">Tarifa:</span>
        <span>{{ $record->tarifa_acceso }}</span>
    </div>
    
    <div class="detail-row">
        <span class="label">Consumo Anual:</span>
        <span>{{ number_format($record->consumo_anual, 0, ',', '.') }}</span>
    </div>
    
    <div class="detail-row">
        <span class="label">Comercializadora:</span>
        <span>{{ $record->comercializadora->nombre }}</span>
    </div>

    @if($comments->count() > 0)
        <div class="comments-section">
            <h2>Comentarios</h2>
            @foreach($comments as $comment)
                <div class="comment">
                    <div class="comment-meta">
                        Por: {{ $comment->user->name }} - 
                        {{ $comment->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="comment-content">
                        {!! $comment->comment !!}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</body>
</html>