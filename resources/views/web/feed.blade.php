<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ {{ $Configuracoes->nomedosite }} ]]></title>
        <link><![CDATA[ {{url('feed')}} ]]></link>
        <description><![CDATA[ {{ $Configuracoes->descricao }} ]]></description>
        <language>pt-br</language>
        <pubDate>{{ now() }}</pubDate>

        @if (!empty($posts) && $posts->count() > 0)
            @foreach($posts as $post)
                <item>
                    <title><![CDATA[{{ $post->titulo }}]]></title>
                    <link>{{ url('blog/artigo/'.$post->slug) }}</link>
                    <image>{{ $post->cover() }}</image>
                    <description><![CDATA[{!! $post->getContentWebAttribute() !!}]]></description>
                    <category>{{ $post->categoriaObject->titulo }}</category>
                    <author><![CDATA[{{ $post->userObject->name }}]]></author>
                    <guid>{{ $post->id }}</guid>
                    <pubDate>{{ date('Y-m-dT H:i:sP', time()) }}</pubDate>
                </item>
            @endforeach
        @endif

        @if (!empty($paginas) && $paginas->count() > 0)
            @foreach($paginas as $pagina)
                <item>
                    <title><![CDATA[{{ $pagina->titulo }}]]></title>
                    <link>{{ url('pagina/'.$pagina->slug) }}</link>
                    <image>{{ $pagina->cover() }}</image>
                    <description><![CDATA[{!! $pagina->getContentWebAttribute() !!}]]></description>
                    <category>{{ $pagina->categoriaObject->titulo }}</category>
                    <author><![CDATA[{{ $pagina->userObject->name }}]]></author>
                    <guid>{{ $pagina->id }}</guid>
                    <pubDate>{{ date('Y-m-dT H:i:sP', time()) }}</pubDate>
                </item>
            @endforeach
        @endif

        @if (!empty($roteiros) && $roteiros->count() > 0)
            @foreach($roteiros as $roteiro)
                <item>
                    <title><![CDATA[{{ $roteiro->name }}]]></title>
                    <link>{{ url('roteiro/'.$roteiro->slug) }}</link>
                    <image>{{ $roteiro->cover() }}</image>
                    <description><![CDATA[{!! $roteiro->getContentWebAttribute() !!}]]></description>
                    <category>Passeios</category>
                    <author><![CDATA[ {{ $Configuracoes->nomedosite }} ]]></author>
                    <guid>{{ $roteiro->id }}</guid>
                    <pubDate>{{ date('Y-m-dT H:i:sP', time()) }}</pubDate>
                </item>
            @endforeach
        @endif
        
        @if (!empty($parceiros) && $parceiros->count() > 0)
            @foreach($parceiros as $parceiro)
                <item>
                    <title><![CDATA[{{ $parceiro->name }}]]></title>
                    <link>{{ url('parceiro/'.$parceiro->slug) }}</link>
                    <image>{{ $parceiro->cover() }}</image>
                    <description><![CDATA[{!! $parceiro->content_web !!}]]></description>
                    <category>Parceiros</category>
                    <author><![CDATA[ {{ $Configuracoes->nomedosite }} ]]></author>
                    <guid>{{ $parceiro->id }}</guid>
                    <pubDate>{{ date('Y-m-dT H:i:sP', time()) }}</pubDate>
                </item>
            @endforeach
        @endif
    </channel>
</rss>