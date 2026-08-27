@extends('layouts.front')
@section('title', 'Error')

@section('content')
    <style>
        

  .bg-black{
        background-color: black;
    }

    .tx-txt{
        color: black;
    font-size: 42px;
    font-weight: 600;
    text-transform: uppercase;
    margin: 15px 0px 10px 0px;
    }
    </style>
   <!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('../assets/frontimages/catagory/SHOP.jpg');">
		<h1 class="ltext-105 cl0 txt-center">
			
		</h1>
	</section>	



		

<section class="text-center pt-5 pb-5">
    <!--<h1 class="tx-txt">Thank you</h1>-->
    <p>Sorry , Order Detail Is Not Available.</p>

    <a href="{{ route('FrontIndex') }}">
    <button class="btn">
        Return To Website
     </button>
     </a>

</section>
@endsection
