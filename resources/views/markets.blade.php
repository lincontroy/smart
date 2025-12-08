@extends('layouts.app')

@section('content')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .main-content {
        height: 100vh;
        padding: 0;
        margin: 0;
    }

    .tradingview-widget-container {
        height: 100%;
        width: 100%;
        position: relative;
    }

    .tradingview-widget-container__widget {
        height: 100% !important;
        width: 100% !important;
    }

    .tradingview-widget-copyright {
        position: absolute;
        bottom: 0;
        width: 100%;
        text-align: center;
        font-size: 12px;
        z-index: 2;
        background: rgba(255,255,255,0.7);
    }
</style>

<main class="main-content">
    <!-- TradingView Widget BEGIN -->
    <div class="tradingview-widget-container">
        <div class="tradingview-widget-container__widget"></div>
        <div class="tradingview-widget-copyright">
            <a href="https://www.tradingview.com/symbols/NASDAQ-AAPL/?exchange=NASDAQ" rel="noopener nofollow" target="_blank">
                <span class="blue-text">AAPL chart by TradingView</span>
            </a>
        </div>
        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
        {
            "allow_symbol_change": true,
            "calendar": false,
            "details": false,
            "hide_side_toolbar": true,
            "hide_top_toolbar": false,
            "hide_legend": false,
            "hide_volume": false,
            "hotlist": false,
            "interval": "D",
            "locale": "en",
            "save_image": true,
            "style": "1",
            "symbol": "NASDAQ:AAPL",
            "theme": "dark",
            "timezone": "Etc/UTC",
            "backgroundColor": "#ffffff",
            "gridColor": "rgba(46, 46, 46, 0.06)",
            "watchlist": [],
            "withdateranges": false,
            "compareSymbols": [],
            "studies": [],
            "autosize": true
        }
        </script>
    </div>
    <!-- TradingView Widget END -->
</main>
@endsection
