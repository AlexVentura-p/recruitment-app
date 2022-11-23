<tr>
<td class="header">
    <h1 style="display: inline-block;">
        @if (trim($slot) === 'Laravel')
        @else
            {{ $slot }}
        @endif
    </h1>
</td>
</tr>
