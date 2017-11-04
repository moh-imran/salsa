@extends('user.partials.masterpage')
@section('content')

<main id="premium_description">
        <section id="container">
            <div class="clearfix"></div>
            <div class="container container_custom">

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="heading_description">
                            <span class="on_pc">Skaffa Skolguiden</span> Premium
                        </h1>
                        <div class="clearfix"></div>
                        <div class="line"></div>

                        <p class="text_description">Med Skolguiden Premium är det enkelt att se hur högstadieskolorna i Norrköping presterar. Du kan enkelt jämföra ditt barns skola med andra skolor och du kan se skolornas starka och svaga sidor. </p>
                    </div>
                </div>

                <div class="row description_row_margin">
                    <div class="col-sm-6 get text_right_center">
                        <img src="/assets/images/description_1.png" alt="" class="description_img">
                    </div>

                    <div class="col-sm-6 set text-center">
                        <div class="description_box text_left_center">
                            <h2 class="description_box_heading">
                                Hitta
                            </h2>
                            <div class="clearfix"></div>
                            <div class="line"></div>

                            <div class="description_box_text">
                                Välj vilka skolor som du vill jämföra. Alla högstadieskolor i Norrköping finns med. Färgmarkeringen ger en första bild av hur skolorna har presterat.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row description_row_margin">
                    <div class="col-sm-6 get text_left_center pull-right">
                        <img src="/assets/images/description_2.png" alt="" class="description_img">
                    </div>

                    <div class="col-sm-6 set text-center">
                        <div class="description_box text_right_center">
                            <h2 class="description_box_heading">
                                Jämför
                            </h2>
                            <div class="clearfix"></div>
                            <div class="line"></div>

                            <div class="description_box_text">
                                För varje skola kan du se förväntat meritvärde och uppnått meritvärde. De ger en bild av hur skolan lyckats förmedla kunskap till sina elever. <br>
                                Meritvärdet är summan av alla betyg i genomsnitt för alla elever på skolan.
                                <div class="description_box_text">
                                    Det förväntade meritvärdet räknas fram med Skolverkets SALSA-modell som kompenserar betygen med socioekonomiska faktorer.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row description_row_margin">
                    <div class="col-sm-6 get text_right_center">
                        <img src="/assets/images/description_3.png" alt="" class="description_img">
                    </div>

                    <div class="col-sm-6 set text-center">
                        <div class="description_box text_left_center">
                            <h2 class="description_box_heading">
                                Behörighet
                            </h2>
                            <div class="clearfix"></div>
                            <div class="line"></div>

                            <div class="description_box_text">
                                Du kan även se hur stor andel av eleverna som fått betyg i alla ämnen och hur stor andel som nått behörighet till olika gymnasieprogram.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row description_row_margin">
                    <div class="col-sm-6 get text_left_center pull-right">
                        <img src="/assets/images/description_4.png" alt="" class="description_img">
                    </div>

                    <div class="col-sm-6 set text-center">
                        <div class="description_box text_right_center">
                            <h2 class="description_box_heading">
                                Detaljerad jämförelse
                            </h2>
                            <div class="clearfix"></div>
                            <div class="line"></div>

                            <div class="description_box_text">
                                Här kan du se varje skolas resultat ner på varje ämne. Vissa skolor är bra på matte, andra på språk.<br>
                                Om det skiljer mycket mellan de betyg som skolan satt och elevernas resultat på nationella prov sätts en varningstriangel ut.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row description_row_margin">
                    <div class="col-md-12 text-center">
                        <h1 class="heading_description no_margin">
                            Skaffa <span class="on_pc">Skolguiden</span> Premium
                        </h1>
                        <div class="clearfix"></div>
                        <div class="line"></div>

                        <p class="text_description">Med Skolguiden Premium är det enkelt att se hur högstadieskolorna i Norrköping presterar. Du kan enkelt jämföra ditt barns skola med andra skolor och du kan se skolornas starka och svaga sidor. </p>
                        @if(Auth::check())
                            <button type="button" class="btn btn_description" onclick="location='/subscribe'">
                                Skolguiden Premium 99<br/>
                                kronor engångsavgift för att se alla skolors resultat
                            </button>
                        @else
                            <button type="button" class="btn btn_description" onclick="location='/register'">
                                Skolguiden Premium <br/>
                                99 kronor engångsavgift för att se alla skolors resultat
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </section>
    </main>

@endsection

@section('script')


<script>
$(document).ready(function () {
     $('[data-toggle="popover"]').popover();
     //$('.popover').remove();
});
$(window).on("load", function(){
    $(".get").each(function(){
        var gt_ht = ($(this).height());

        $(this).next(".set").css("line-height", gt_ht+"px").css("min-height", gt_ht+"px")
        $(this).prev(".set").css("line-height", gt_ht+"px").css("min-height", gt_ht+"px")
    })
})
</script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->


@endsection