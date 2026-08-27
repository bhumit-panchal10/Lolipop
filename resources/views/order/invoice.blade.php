<style>
    table,
    th,
    td {
        border: 1px solid black !important;
        border-collapse: collapse !important;
        padding: 5px !important;
        font-family: sans-serif !important;
    }

    * {
        font-family: DejaVu Sans !important;
    }
</style>


<table style="width: 100%;">


    <tr>
        <td style="text-align: center;">
            <img width="150" src="https://www.thewardrobefashion.in/assets/front/images/logo-2.png" alt="">
        </td>
    </tr>

    <table style="width: 100%;">
        <tr>
            <td style="border: 1px solid #000000;font-weight: 600;">Address:</td>
            <td style="border: 1px solid #000000;">To,</td>
        </tr>

        <tr>
            <td style="border: 1px solid #000000;">10 , Shakti Appartment ,</td>
            @if ($data->shipping_cutomerName != '')
                <td style="border: 1px solid #000000;">{{ $data->shipping_cutomerName }}</td>
            @else
                <td style="border: 1px solid #000000;">{{ $data->cutomerName }}</td>
            @endif
        </tr>

        <tr>
            <td style="border: 1px solid #000000;">Bhairavnath Road ,</td>

            <td style="border: 1px solid #000000;">{{ $data->shiiping_address1 }}</td>

        </tr>

        <tr>
            <td style="border: 1px solid #000000;"> Kankaria , Ahmedabad </td>

            <td style="border: 1px solid #000000;">{{ $data->shiiping_address2 }}</td>

        </tr>

        <tr>
            <td style="border: 1px solid #000000;"> Gujarat – 380028</td>

            <!--<td style="border: 1px solid #000000;">{{ $data->stateName  . ' - ' .  $data->shipping_pincode }}</td>-->
            <td style="border: 1px solid #000000;">
                {{ $data->shipping_city. ',' . $data->shipping_pincode . ' - ' . $data->stateName . '  ' . $data->country }}</td>

        </tr>

        <?php if($data->couriername || $data->docketNo){  ?>
            <tr>
                <td style="border: 1px solid #000000;"></td>
                <td style="border: 1px solid #000000;">{{ $data->couriername . '-' . $data->docketNo }}</td>
            </tr>
        <?php } ?>    
        
        <tr>
            <td style="border: 1px solid #000000;"></td>
            <?php if($data->shipping_mobile){ ?>
                <td style="border: 1px solid #000000;">{{ $data->shipping_mobile }}</td>
            <?php } else if($data->shipping_mobile1){ ?>    
                <td style="border: 1px solid #000000;">{{ $data->shipping_mobile1 }}</td>
            <?php } else { ?>
                <td style="border: 1px solid #000000;"> {{ $data->shipping_mobile .' , '. $data->shipping_mobile1  }}</td>
            <?php } ?>
        </tr>

    </table>


    <table style="width: 100%;">

        <tr>
            <td style="text-align: center;background-color: #603813;color: white;">Sr No</td>
            <td style="text-align: center;background-color: #603813;color: white;">Product Name</td>
            <td style="text-align: center;background-color: #603813;color: white;">Photo</td>
            <td style="text-align: center;background-color: #603813;color: white;">Size</td>
            <td style="text-align: center;background-color: #603813;color: white;">Qty</td>
            <td style="text-align: center;background-color: #603813;color: white;">Rate</td>
            <td style="text-align: center;background-color: #603813;color: white;">Amount</td>
        </tr>

        <?php $i = 1;
        $iTotal = 0;
        $ShippingRate = 0;
        ?>
        @foreach ($detail as $details)
           
            <tr>
                <td style="text-align: center">{{ $i }}</td>
                <td style="text-align: center">{{ $details->productname }}</td>
                <td style="text-align: center">
                    <img class="img-1" width="48" height="48" src="{{ asset('Product/Thumbnail/') . '/' . $details->photo }}">
                </td>
                <td style="text-align: center">{{ $details->product_attribute_size }}</td>
                <td style="text-align: center">{{ $details->quantity }}</td>
                <td style="text-align: center">{{ $details->rate }}</td>
                <td>Rs.{{ $details->amount }}</td>
            </tr>
            <?php
            $Amount = $details->amount;
            $iTotal = $iTotal * 1 + $Amount * 1;
            ?>

            <?php $i++; ?>
        @endforeach
        <?php
        $total = $iTotal * 1;
        ?>

       
        <tr>
            <td style="border: 1px solid white;border-right: 1px solid black;" colspan="5"></td>
            <td style="text-align: center;background-color: #603813;color: white;" colspan="1">Net Amount</td>
            <td colspan="1">Rs.<?php echo $total; ?></td>
        </tr>

        <!--<tr>-->
        <!--    <td style="border: 1px solid white;border-right: 1px solid black;" colspan="4"></td>-->
        <!--    <td style="text-align: center;background-color: #603813;color: white;" colspan="1">Discount</td>-->
        <!--    <?php if($data->discount){  ?>-->
        <!--        <td colspan="1">Rs.{{ $data->discount }}</td>-->
        <!--    <?php }else{ ?>    -->
        <!--        <td  colspan="1">-</td>-->
        <!--    <?php } ?>        -->
        <!--</tr>-->
        
        <!--<tr>-->
        <!--    <td style="border: 1px solid white;border-right: 1px solid black;" colspan="4"></td>-->
        <!--    <td style="text-align: center;background-color: #603813;color: white;" colspan="1">Net Amount</td>-->
        <!--    <td colspan="1">Rs.{{ $data->netAmount }}</td>-->
        <!--</tr>-->
    </table>
    <?php //dd('Hello');
    ?>


</table>
