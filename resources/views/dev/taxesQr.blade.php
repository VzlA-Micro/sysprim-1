<div class="visible-print text-center">

    <table>
        <tr>
            <td></td><td>  <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate('Make me into an QrCode!')) !!} "></td><td></td>
        </tr>
    </table>


    <p></p>
</div>