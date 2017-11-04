@extends('user.partials.masterpage')
@section('content')
<main id="about">
    
 
    <section id="container">
        <div class="clearfix"></div>
<!--        <div class="title_text">
            <span>Idag är det 43 dagar kvar</span>
        </div>-->

        <div class="container container_custom" style="margin-top: 50px; background:#fff">

            <div class="row">
                <div class="col-md-12">
    <div class="modal fade" id="myModal" style="z-index:10000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>SALSA-modellen räknar ut vad en skolas genomsnittliga betygsnivå borde vara med hänsyn tagen till tre bakgrundsfaktorer; vilken utbildningsnivå föräldrarna har, andelen nyinvandrade elever kombinerat med elever med okänd bakgrund samt andelen pojkar och flickor. Den förväntade betygsnivån jämförs därefter med de betyg som eleverna faktiskt fått. Resultatet är ett SALSA-värde.</p>
                    
                    <p>Ett positivt SALSA-resultat visar att skolan har presterat bättre än förväntat. Det pekar mot att skolans kvalitet är hög. Ett negativt SALSA-resultat visar å andra sidan att skolan har underpresterat i förhållande till elevernas förutsättningar.</p>
                    <p>SALSA-modellen är utvecklad av Skolverket.</p>
                   <p> De bakgrundsfaktorer som ingår i den statistiska modellen förklarar 63 % av variationen i skolors resultat (läsåret 2014/15). 37 % av variationen beror på andra faktorer. SALSA-värden för landets skolor samlas i databasen SIRIS och det är därifrån som Skolguiden.nu hämtar alla data. </p>
                   <p> Men kan man lita på betygen? Sätter inte vissa skolor ”glädjebetyg” för att bli mer attraktiva? Jo, det händer. Därför har vi jämfört betygsresultaten med resultaten på nationella prov. Om vi har funnit att dessa avviker för mycket så har vi satt ut en varningstriangel. </p> 
                   <p> Triangeln varnar för att en skolas betygsnivåer inte stämmer med vad eleverna faktiskt kan – eller i alla fall har visat att de kan på de nationella proven. Ibland är betygen för låga – ibland för höga. Det är vanligare att en skola sätter för höga än för låga betyg. När du ser varningstriangeln så ska du därför vara försiktig med att dra slutsatser av de faktiska betygsresultaten.</p>
                </div>
            </div>
        </div>
    </div>
            <h1 align="center">Om Skolguiden.nu</h1>
            <div class="line">&nbsp;</div>
                <div class="text-left">
                    <p class="about_text">Är skolor där elever har höga betyg  bra skolor - och är skolor med lägre betyg dåliga? Inte nödvändigtvis.<br>
                        Att mäta skolors kvalitet är svårt – men inte omöjligt. Så här ser vi på saken:<br>
                        Det finns främst två orsaker till en elevs betygsresultat; dels elevens bakgrund, uppväxt- och hemförhållanden. Vi kallar det bakgrundsfaktorer. Dels kvaliteten på skolan som eleven går i vilket vi menar inkluderar hur mycket eleven anstränger sig och studerar.<br> <br>
                        Att jämföra olika skolors betygsresultat utan att ta hänsyn till bakgrundsfaktorerna blir missvisande. Höga betygsresultat kan lika gärna avspegla bakgrundsfaktorer som kvaliteten på undervisningen. Till synes höga resultat kan till och med dölja kvalitetsbrister i skolan.<br>
                         </p>
                    <p class="about_text">Med den här tjänsten vill vi ge föräldrar och elever som ska välja skola ett verktyg för att hitta skolor som har hög kvalitet på sin undervisning och undvika skolor med låg kvalitet.<br><br>
                        Vi har använt Skolverkets s k Salsamodell. Salsamodellen räknar ut vad en skolas genomsnittliga betygsnivå borde vara med hänsyn tagen till tre bakgrundsfaktorer.<br>
                    </p>
                    <p class="about_text" style="cursor: pointer; margin-top: 10px;" data-toggle="modal" data-target="#myModal"> Läs mer om SALSA...</p>
                    <h3 align="center">Vi startar i Norrköping</h3>
                    <p class="about_text" style="margin-top: 11px;">Skolguiden.nu finns bara i Norrköping ännu så länge, men kommer senare att lanseras i hela landet.</p>
                </div>
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
 
</script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->


@endsection