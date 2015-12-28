<section id="intro" class="fx-backstretch">
    <div class="info">
        <div class="container">
            <div class="row">
                <div class="col-full"><h1>{[NAME_ENGINE]}<span class="cool">0.3</span></h1></div>
            </div>
            <div class="row"><div class="col-1-4 centered line"></div></div>
            <div class="row">
                <div class="col-full"><h4>{[DESC_ENGINE]} <span class="ajax-area text-center"><span class="ajax-btn"><small>Нажми на меня</small></span></span></h4></div>
            </div>
        </div>
    </div>
</section>
<section id="profile" class="section">
    <div class="container">
        <div class="row">
            <div class="col-full">
                <h2 class="section-title">{[WHATS_NEW]}</h2>
                <div class="centered line"></div>
            </div>
        </div>

        <div class="row section-content wel-sec">
            <div class="col-1-3">
                <h3>{[HEAD_1]}</h3>

                <p>{[P_1]}</p>
                
                <ul class="ul-list">
                    {[FOREACH([LIST_1]):START]}
                        <li>{[LIST]}</li>
                    {[FOREACH:END]}
                </ul>
            </div>
            <div class="col-1-3">
                    <h3>{[HEAD_2]}</h3>

                    <p>{[P_2]}</p>

                    <ul class="ul-list">
                        {[FOREACH([LIST_2]):START]}
                            <li><a href="{[LINK]}">{[TEXT]}</a></li>
                        {[FOREACH:END]}
                    </ul>
            </div>
            <div class="col-1-3">
                    <h3>{[HEAD_2]}</h3>

                    <p>{[P_2]}</p>

                    <ul class="ul-list">
                        {[FOREACH([LIST_3]):START]}
                            <li><span class="fa icon-ok"></span> {[LIST]}</li>
                        {[FOREACH:END]}
                    </ul>
            </div>
        </div>
    </div>
</section>
<footer>
    <div class="container">
        {[COPYRIGHT]}
    </div>
</footer>
<script  type="text/javascript">
    $(".ajax-btn" ).click(function() {
        $(".ajax-area").load('#?ajax=1');
    });
</script>