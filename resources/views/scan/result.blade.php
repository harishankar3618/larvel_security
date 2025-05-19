@extends('layouts.app') {{-- Or use basic HTML if not using Blade layouts --}}

@section('content')
<div style="font-family: monospace; padding: 20px; max-width: 1000px; margin: auto;">

    <h2>Scan Report Summary</h2>

    {{-- Back Button --}}
    <form action="{{ route('scan.form') }}" method="GET" style="margin-bottom: 20px;">
        <button type="submit" style="padding: 8px 16px; background-color: #3490dc; color: white; border: none; border-radius: 4px; cursor: pointer;">
            ⬅️ New Scan
        </button>
    </form>

    {{-- Raw Output --}}
    <h3>🔧 Raw Scanner Output</h3>
    <pre style="background-color: #f4f4f4; padding: 10px; border-left: 4px solid #ccc;">{{ strip_tags($result) }}</pre>

    {{-- Parsed JSON Output --}}
    @if ($scanResult)
        <h3>📄 Target</h3>
        <p><strong>{{ $scanResult['target'] }}</strong></p>

        <h3>⏱️ Timestamp</h3>
        <p>{{ $scanResult['timestamp'] }}</p>

        <h3>🔓 Open Ports</h3>
        <ul>
            @foreach ($scanResult['open_ports'] as $port)
                <li>Port {{ $port }}</li>
            @endforeach
        </ul>

        <h3>🛰️ Service Banners</h3>
        <ul>
            @foreach ($scanResult['service_banners'] as $port => $info)
                <li><strong>Port {{ $port }}</strong>: {{ $info['service'] }} ({{ $info['protocol'] }})</li>
            @endforeach
        </ul>

        <h3>🔍 Web Findings</h3>
        @if (!empty($scanResult['web_findings']))
            <ul>
                @foreach ($scanResult['web_findings'] as $finding)
                    <li>
                        <strong>{{ $finding['type'] }}</strong> on 
                        <a href="{{ $finding['url'] }}" target="_blank">{{ $finding['url'] }}</a><br>
                        Detail: {{ $finding['detail'] }}<br>
                        Severity: <span style="color: orange;">{{ $finding['severity'] }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No web findings found.</p>
        @endif

        <h3>🧭 Vulnerabilities</h3>
        @if (!empty($scanResult['vulnerabilities']))
            <pre>{{ json_encode($scanResult['vulnerabilities'], JSON_PRETTY_PRINT) }}</pre>
        @else
            <p>No vulnerabilities found.</p>
        @endif

        <h3>📚 CVE Matches</h3>
        @if (!empty($scanResult['cve_matches']))
            <pre>{{ json_encode($scanResult['cve_matches'], JSON_PRETTY_PRINT) }}</pre>
        @else
            <p>No CVE matches found.</p>
        @endif
    @else
        <p>No JSON report found or failed to parse report.</p>
    @endif
</div>
@endsection
