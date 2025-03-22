<!-- resources/views/programs/marktable.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Base styles */
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
        }

        /* Background colors from original table */
        .header-bg {
            background-color: #F6F8FA;
        }
        
        .grand-total {
            background-color: #00C875 !important;
            color: white;
        }
        
        .grand-percentage {
            background-color: #5CA3FF !important;
            color: white;
        }
        
        .total-column {
            background-color: #FFDD00 !important;
        }
        
        .percentage-column {
            background-color: #FFAB2A !important;
            color: white;
        }

        /* Dynamic styles from tableData.styles */
        @foreach($tableData['styles'] as $style)
        .{{ $style['className'] }} {
            background-color: {{ $style['backgroundColor'] }};
            color: {{ $style['color'] }};
            text-align: {{ $style['textAlign'] }};
        }
        @endforeach
    </style>
</head>
<body>
    <table>
        <thead>
            @foreach($tableData['headers'] as $headerRow)
                <tr>
                    @foreach($headerRow as $header)
                        <th 
                            @if($header['rowspan'] > 1) rowspan="{{ $header['rowspan'] }}" @endif
                            @if($header['colspan'] > 1) colspan="{{ $header['colspan'] }}" @endif
                            class="{{ $header['className'] }}"
                            style="background-color: {{ $header['backgroundColor'] }};"
                        >
                            {!! $header['content'] !!}
                        </th>
                    @endforeach
                </tr>
            @endforeach
        </thead>
        <tbody>
            @foreach($tableData['rows'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td class="{{ $cell['className'] }}"
                            style="background-color: {{ $cell['backgroundColor'] }};"
                        >
                            {{ $cell['content'] }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>