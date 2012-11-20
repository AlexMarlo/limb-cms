-- MySQL dump 10.13  Distrib 5.1.66, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: limb_cms
-- ------------------------------------------------------
-- Server version	5.1.66-0ubuntu0.11.10.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


/*!40000 ALTER TABLE `lmb_cms_user` DISABLE KEYS */;
INSERT INTO `lmb_cms_user` VALUES(
  NULL,
  'support@limb-project.com',
  'Admin',
  'b9fb54d1cf88c8c9141cdb01215969221899ff97', /* secret */
  NULL,
  'admin',
  'admin',
  1
);
/*!40000 ALTER TABLE `lmb_cms_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


/*!40000 ALTER TABLE `lmb_cms_seo` DISABLE KEYS */;
INSERT INTO `lmb_cms_seo` (`id`, `url`, `title`, `description`, `keywords`) VALUES(
  1,
  '/',
  'Главная страница Сайта',
  'Описание',
  'Ключевые слова'
);
/*!40000 ALTER TABLE `lmb_cms_seo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40000 ALTER TABLE `lmb_cms_document` DISABLE KEYS */;
INSERT INTO `lmb_cms_document` (`title`, `is_published`, `content`) VALUES ('/', 1, '
<h1>Добро пожаловать в Limb!</h1>
    <div style="text-align:right">
      <blockquote>И всё-таки она вертится!</blockquote>
      <cite><a href="http://ru.wikipedia.org/wiki/%D0%98_%D0%B2%D1%81%D1%91-%D1%82%D0%B0%D0%BA%D0%B8_%D0%BE%D0%BD%D0%B0_%D0%B2%D0%B5%D1%80%D1%82%D0%B8%D1%82%D1%81%D1%8F!">Галилео Галилей</a></cite>
    </div>
    <h2><a name="примеры_для_начинающих" id="примеры_для_начинающих">Примеры для начинающих</a></h2>
    <p>Для освоения Limb3 есть 2 пошаговых примера:</p>
    <ul>
      <li class="level1"><div class="li"> <a href="http://wiki.limb-project.com/doku.php?id=limb3:ru:tutorials:basic" class="wikilink1" title="limb3:ru:tutorials:basic">базовый пример</a>, где показаны только самые основы использования пакетов WEB_APP, ACTIVE_RECORD и WACT.</div></li>
      <li class="level1"><div class="li"> <a href="http://wiki.limb-project.com/doku.php?id=limb3:ru:tutorials:shop" class="wikilink1" title="limb3:ru:tutorials:shop">пример создания простого электронного магазина</a>, в котором объяснены почти все часто используемые компоненты Limb3.</div></li>
    </ul>

    <p>Рабочий код примеров можно найти в SVN репозитории по адресу:</p>
    <pre class="code">  svn co https://svn.limb-project.com/limb/3.x/examples</pre>

    <p>или же в разделе <a href="http://bits.limb-project.com/" class="urlextern" title="http://bits.limb-project.com/" rel="nofollow">Code Bits</a>, где представлены рабочие копии этих примеров, а также ссылки для скачивания исходных кодов.</p>

    <p>Вы сможете найти в настоящее время следующие примеры и приложения:</p>
    <ul>
      <li class="level1"><div class="li"> реализацию основного сайта <a href="http://limb-project.com" class="urlextern" title="http://limb-project.com" rel="nofollow">http://limb-project.com</a> на базе Limb3</div></li>
      <li class="level1"><div class="li"> пример создание простейшего CRUD-приложения</div></li>
      <li class="level1"><div class="li"> пример создания простого электронного магазина</div></li>
      <li class="level1"><div class="li"> пример реализации корпоративной визитки с каталогом</div></li>
      <li class="level1"><div class="li"> примеры использования шаблонизатора WACT</div></li>
      <li class="level1"><div class="li"> готовые приложения на базе Limb3: <a href="http://syncman.limb-project.com" class="urlextern" title="http://syncman.limb-project.com" rel="nofollow">Syncman</a> и <a href="http://buildman.limb-project.com" class="urlextern" title="http://buildman.limb-project.com" rel="nofollow">Buildman</a></div></li>
    </ul>

    <h2><a name="документация" id="документация">Документация</a></h2>
    <p>Документация на Limb3 достаточно актуальна. Наиболее точными являются разделы <a href="/doku.php?id=limb3:ru:packages:wact" class="wikilink1" title="limb3:ru:packages:wact">про WACT</a> и <a href="/doku.php?id=limb3:ru:packages:active_record" class="wikilink1" title="limb3:ru:packages:active_record">про использование ACTIVE_RECORD</a>. Эти разделы мы рекомендуем прочитать после прохождения <a href="/doku.php?id=limb3:ru:tutorials:basic" class="wikilink1" title="limb3:ru:tutorials:basic">базового примера</a>.</p>

    <p>Также есть <a href="/doku.php?id=limb3:ru:packages" class="wikilink1" title="limb3:ru:packages">описания на большинство пакетов Limb3</a>. В этих разделах информация частично, а кое-где и сильно, устарела. Хотя мы постепенно исправляем ситуацию, но это требует очень много времени, и поэтому прогресс идет достаточно медленно. Так что, если что-то из этих разделов будет вам неясным, то можете спрашивать на <a href="http://forum.limb-project.com/" class="urlextern" title="http://forum.limb-project.com/" rel="nofollow">форуме</a> - мы стараемся отвечать на большинство вопросов оперативно и развернуто.</p>

    <h2><a name="модульные_тесты" id="модульные_тесты">Модульные тесты</a></h2>
    <p>Для большинства классов и подсистем Limb3 существуют модульные тесты. Разработчики знакомые с тестированием смогут найти множество примеров использования тех или иных классов в тестах. Подробнее о тестах и способах их запуска можно прочитать в <a href="/doku.php?id=limb3:ru:how_to_run_tests" class="wikilink1" title="limb3:ru:how_to_run_tests">соответствующем разделе</a>.</p>

    <h2><a name="варианты_использования_limb3" id="варианты_использования_limb3">Варианты использования Limb3</a></h2>
    <p>Вы можете использовать Limb3 как полностью законченный фреймворк, создавая на его базе приложения или же использовать из него только отдельные пакеты, например:</p>

    <ul>
      <li class="level1"><div class="li"> TESTS_RUNNER - пакет для запуска тестов</div></li>
      <li class="level1"><div class="li"> ACTIVE_RECORD - имплементация паттерна ActiveRecord, позволяющая прозрачно отражать объекты в реляционную БД</div></li>
      <li class="level1"><div class="li"> MACRO - шаблонизатор</div></li>
      <li class="level1"><div class="li"> TOOLKIT - инструмент для управления зависимостями</div></li>
      <li class="level1"><div class="li"> и т.д.</div></li>
    </ul>

    <h2><a name="требования_к_хостингу" id="требования_к_хостингу">Требования к хостингу</a></h2>
    <p>С требованиями к среде, в которой будет работать Limb3, вы можете ознакомится на <a href="/doku.php?id=limb3:ru:claim" class="wikilink1" title="limb3:ru:claim">соответствующей странице</a>.</p>

    <h2><a name="если_вам_нужна_помощь" id="если_вам_нужна_помощь">Если вам нужна помощь</a></h2>
    <p>Не стесняйтесь, спрашивайте на <a href="http://forum.limb-project.com" class="urlextern" title="http://forum.limb-project.com" rel="nofollow">форуме</a>. Мы всегда постараемся ответить на ваши вопросы.</p>

    <h2>Пакеты limb3 и их функции</h2>
    <p>С полный список пакетов можно ознакомиться на соответствующей странице wiki проекта.</p>

    <h3>core</h3>
      <p>Базовый пакет, отвечающий за поддержку подключения других пакетов. Содержит базовые классы для работы с различными контейнерами данных и коллекциями. Практически все остальные пакеты зависят от него.</p>
      <ul>
        <li>подключение классов и поддержка отложенной загрузки кода (autoload)</li>
        <li>отложенная инициализация объектов</li>
        <li>контейнеры данных (как списковые, так и несписковые контейнеры данных)</li>
        <li>объектные формы call_back вызовов</li>
        <li>различные утилитарные классы для сериализации, создания декораторов на лету, упрощению работы с массивами</li>
      </ul>

    <h3>toolkit</h3>
    <p>Пакет является реализацией <a href="/wiki/%D0%9F%D0%B0%D1%82%D1%82%D0%B5%D1%80%D0%BD" title="Паттерн">паттерна</a> <a href="/w/index.php?title=Dynamic_Service_Locator&amp;action=edit&amp;redlink=1" class="new" title="Dynamic Service Locator (страница отсутствует)">Dynamic Service Locator</a>. Его суть состоит в том, что есть некий легко доступный объект, который является общим местом для доступа ко всем популярным объектам (сервисам) и в том, что возможности этого объекта можно легко расширять.</p>

    <h3>macro</h3>
    <p>Пакет реализует относительно простой компилирующий шаблонизатор, со следующими особенностями:</p>

    <ul>
      <li>никаких ограничений на РНР-вставки</li>
      <li>включение и враппинг шаблонов (с поддержкой зон)</li>
      <li>облегчённая поддержка контекстов данных (локальные и глобальные данные)</li>
      <li>отсутствие runtime дерева компонентов</li>
      <li>модификация данных производится с помощью фильтров</li>
    </ul>

    <h3>dbal (Data Base Abstraction Layer)</h3>
    <p>Пакет предоставляет объектно-ориентированный доступ к <a href="/wiki/%D0%91%D0%B0%D0%B7%D0%B0_%D0%B4%D0%B0%D0%BD%D0%BD%D1%8B%D1%85" title="База данных">базе данных</a>, абстрагируясь от деталей конкретной реализации. В данный момент поддерживаются следующие базы данных: <a href="/wiki/MySQL" title="MySQL">MySQL</a> (<a href="/wiki/MySQLi" title="MySQLi">MySQLi</a>), <a href="/wiki/PostgreSQL" title="PostgreSQL">PostgreSQL</a>, <a href="/wiki/SQLite" title="SQLite">SQLite</a> и <a href="/wiki/Oracle" title="Oracle">Oracle</a>.</p>

    <p><a name="active_record" id="active_record"></a></p>

    <h3>active_record</h3>
    <p>Реализация <a href="/wiki/%D0%9F%D0%B0%D1%82%D1%82%D0%B5%D1%80%D0%BD" title="Паттерн">паттерна</a> <a href="/w/index.php?title=ActiveRecord&amp;action=edit&amp;redlink=1" class="new" title="ActiveRecord (страница отсутствует)">ActiveRecord</a>, отчасти схожего с реализацией подобного паттерна в <a href="/wiki/Ruby_on_Rails" title="Ruby on Rails">Ruby on Rails</a>.</p>

    <ul>
      <li>автоматическое определение наименований и типов полей таблицы</li>
      <li>поддержка отношений один-к-одному, один-ко-многим и много-ко-многим</li>
      <li>поддержка ValueObjects</li>

      <li>поддержка наследования в рамках одной таблицы (Single Table Inheritance)</li>
      <li>поддержка «отложенной загрузки» (LazyLoading) для коллекций</li>
      <li>тесная интеграция с шаблонизатором</li>
    </ul>

    <h3>web_app</h3>
    <p>Пакет позволяет строить веб-приложения, применяя паттерн <a href="/wiki/MVC" title="MVC" class="mw-redirect">MVC</a>. Сам пакет предоставляет классы для реализации только Controller-составляющей. Выбор средства для реализации модели и отображения всё равно лежит на конечном разработчике приложения, хотя WEB_APP реализован таким образом, чтобы максимально упростить работу с приложениями, где в качестве модели будут выбраны «родные» для Limb3 пакеты DBAL и ACTIVE_RECORD, а в качестве отображения — пакет VIEW.</p>

    <h3>tests_runner</h3>
    <p>Пакет для организации и запуска <a href="/w/index.php?title=SimpleTest&amp;action=edit&amp;redlink=1" class="new" title="SimpleTest (страница отсутствует)">SimpleTest</a> тестов для приложений, которые содержат большие тестовые наборы. В поставку с пакетом входят классы, которые позволяют выполнять тесты в <a href="/wiki/CLI" title="CLI">cli</a> или <a href="/wiki/Web" title="Web" class="mw-redirect">web</a>-режиме.</p>
');
/*!40000 ALTER TABLE `lmb_cms_document` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-19 20:18:01
