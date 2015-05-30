{[BLOCK_HEADER]}
    <div class="container text-center">
      <div class="jumbotron">
        <h1 class="text-center">{[HEADING]}</h1>
        <h2 class="text-center">I am Remus {[VERSION]}</h2>
        <div class="ajax-area text-center"><button class="btn btn-primary ajax-btn">Click Me!</button></div>
      </div>
    </div>
    <div class="container">
      <div class="row">
          <div class="col-md-9">
            <div class="col-md-4">
              <h2>Новая настраиваемая структура</h2>
              <p>Полностью настраиваемая структура файлов позволит вам более гибко подходить к разработке приложений.</p>
              <p></p>
            </div>
            <div class="col-md-4">
              <h2>Модульность</h2>
              <p>Фреймворк поддерживает полную смену базовых классов MVC.</p>
            </div>

            <div class="col-md-4 col-lg-4">
              <h2>Новые встроеннные компоненты</h2>
              <p>Блягодаря <b>QueryBuilder</b> вы сможете быстро получить доступ к данным из БД.</p>
            </div>
          </div>
          <div class="col-md-3">
              <div class="list-group">
                {[FOREACH([LINKS]):START]}
                    {[BLOCK_BLOC]}
                {[FOREACH:END]}
              </div>
          </div>
      </div>
      <hr>
      <footer>
        <div class="btn-group">
            <a href="https://github.com/RomensTeam" class="btn btn-primary">RomensTeam</a> 
            <span class="btn btn-default">{[COPYRIGHT]}</span>
        </div>
      </footer>
    </div>