{[BLOCK_HEADER]}
    <div class="container text-center">
      <div class="jumbotron">
        <h1 class="text-center">Hello, World!</h1>
        <h2 class="text-center">I am Remus {[VERSION]}</h2>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h2>Новая Структура</h2>
          <p>Более приятная структура файлов, которая позволит вам более гибко подходить к разработке приложений</p>
          <p></p>
        </div>
        <div class="col-md-4">
          <h2>Улучшенная поддержка мультиязычности</h2>
          <p>Теперь фреймворк поддерживает языки в стандарте.</p>
          <p>Пример: <span class="label label-success">ru_RU</span> <span class="label label-info">en_US</span></p>
        </div>
		  
        <div class="col-md-4 col-lg-4">
          <h2>Новая защита</h2>
          <p>Была улучшена защита фреймворка</p>
        </div>
      </div>
    <ul>
{[FOREACH(TEST):START]}
    {[BLOCK_LIST]}
{[FOREACH:END]}  
    </ul>
      <hr>
      <footer>
        <div class="btn btn-group">
            <a href="https://github.com/RomensTeam" class="btn btn-primary">RomensTeam</a> 
            <span class="btn btn-default">{[COPYRIGHT]}</span>
        </div>
      </footer>
    </div>