@extends('layouts.front')
@section('title', 'Policy')
@section('content')


    <main class="terms-page">
        <section class="terms-section">
            <div class="container">
                <!-- =================================================
                                                                 PAGE INTRO
                                                            ================================================== -->
                <div class="terms-intro">
                    <div class="terms-intro-copy">
                        <span class="terms-kicker">
                            SHOP WITH CONFIDENCE
                        </span>
                        <h2>
                            {!! $datas->pagename !!}
                        </h2>

                    </div>
                </div>

                <div class="terms-layout">

                    <div class="terms-content">

                        <article class="terms-card" id="termsIntroduction">

                            <div class="terms-card-body">
                                <p>
                                    {!! $datas->description !!}
                                </p>

                            </div>
                        </article>

                    </div>
                </div>
            </div>
        </section>
    </main>


@endsection
