
<?php
require_once 'config.php';

// Получаем сохраненные данные из cookies
$form_data = [
    'name' => $_COOKIE['name'] ?? '',
    'phone' => $_COOKIE['phone'] ?? '',
    'mail' => $_COOKIE['mail'] ?? '',
    'bdate' => $_COOKIE['bdate'] ?? '',
    'gender' => $_COOKIE['gender'] ?? '',
    'languages' => isset($_COOKIE['languages']) ? json_decode($_COOKIE['languages'], true) : [],
    'bio' => $_COOKIE['bio'] ?? ''
];

// Получаем ошибки из сессии
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

// Получаем флаг успешной отправки
$success = $_SESSION['success'] ?? false;
unset($_SESSION['success']);
$update_success = $_SESSION['update_success'] ?? false;
unset($_SESSION['update_success']);
?>


<!DOCTYPE html>
<html lang="en">
  <html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Drupal Coder</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <script
      src="https://code.jquery.com/jquery-3.7.1.js"
      integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
      crossorigin="anonymous"
    ></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" defer></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap"
      rel="stylesheet"
    />
    <script src="src/slick.js" defer></script>
    <script src="main.js" defer></script>
    <link rel="stylesheet" href="src/slick-theme.css" />
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.tailwindcss.com" defer></script>
    <style>
        .error { color: red; font-size: 0.8rem; margin-top: -0.5rem; margin-bottom: 0.5rem; }
        .error-field { border-color: red !important; }
        .success-message { color: green; margin-bottom: 1rem; text-align: center; }
        .form-container { max-width: 800px; margin: 0 auto; }
    </style>
</head>
  <body>
    <header>
      <div class="navbar" id="navbar">
        <div class="mobile-nav">
          <img
            src="src/img/drupal-coder.svg"
            class="drup-logo"
            alt="drupal-logo"
          />
          <button class="navbar-toggle" id="navbar-toggle">
            <div class="buttonlines">
              <div class="nav-button-line"></div>
              <div class="nav-button-line"></div>
              <div class="nav-button-line"></div>
            </div>
          </button>
        </div>

        <ul class="navmenu" style="display: none" id="mobileMenu">
          <li class="menuline">
            <a href="https://drupal-coding.com/support" class="menulink"
              >ПОДДЕРЖКА DRUPAL</a
            >
          </li>
          <li class="menuline">
            <div class="menulinewrapper">
              <a href="https://drupal-coding.com/drupal-admin" class="menulink"
                >АДМИНИСТРИРОВАНИЕ</a
              >
              <div class="triangle"></div>
            </div>
            <ul class="innermenu">
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/import-migrate-upgrade"
                  class="menulink innermenulink"
                  >МИГРАЦИЯ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/backup"
                  class="menulink innermenulink"
                  >БЭКАПЫ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/drupal-security-audit"
                  class="menulink innermenulink"
                  >АУДИТ БЕЗОПАСНОСТИ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/boost-drupal"
                  class="menulink innermenulink"
                  >ОПТИМИЗАЦИЯ СКОРОСТИ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/ssl"
                  class="menulink innermenulink"
                  >ПЕРЕЕЗД НА HTTPS</a
                >
              </li>
            </ul>
          </li>
          <li class="menuline"><a href="" class="menulink">ПРОДВИЖЕНИЕ</a></li>
          <li class="menuline">
            <a href="https://drupal-coding.com/drupal-seo" class="menulink"
              >РЕКЛАМА</a
            >
          </li>
          <li class="menuline">
            <div class="menulinewrapper">
              <a href="https://drupal-coding.com/team" class="menulink"
                >О НАС</a
              >
              <div class="triangle"></div>
            </div>
            <ul class="innermenu">
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/team#team"
                  class="menulink innermenulink"
                  >КОМАНДА</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/drupalgive"
                  class="menulink innermenulink"
                  >DRUPALGIVE</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/blog"
                  class="menulink innermenulink"
                  >БЛОГ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/drupal-courses"
                  class="menulink innermenulink"
                  >КУРСЫ DRUPAL</a
                >
              </li>
            </ul>
          </li>
          <li class="menuline"><a href="" class="menulink">ПРОЕКТЫ</a></li>
          <li class="menuline">
            <a href="https://drupal-coding.com/contacts" class="menulink"
              >КОНТАКТЫ</a
            >
          </li>
        </ul>
        <ul class="navmenu" id="desktopMenu">
          <li class="menuline">
            <a href="https://drupal-coding.com/support" class="menulink"
              >ПОДДЕРЖКА DRUPAL</a
            >
          </li>
          <li class="menuline">
            <div class="menulinewrapper">
              <a href="https://drupal-coding.com/drupal-admin" class="menulink"
                >АДМИНИСТРИРОВАНИЕ</a
              >
              <div class="triangle"></div>
            </div>
            <ul class="innermenu">
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/import-migrate-upgrade"
                  class="menulink innermenulink"
                  >МИГРАЦИЯ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/backup"
                  class="menulink innermenulink"
                  >БЭКАПЫ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/drupal-security-audit"
                  class="menulink innermenulink"
                  >АУДИТ БЕЗОПАСНОСТИ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/boost-drupal"
                  class="menulink innermenulink"
                  >ОПТИМИЗАЦИЯ СКОРОСТИ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/ssl"
                  class="menulink innermenulink"
                  >ПЕРЕЕЗД НА HTTPS</a
                >
              </li>
            </ul>
          </li>
          <li class="menuline"><a href="" class="menulink">ПРОДВИЖЕНИЕ</a></li>
          <li class="menuline">
            <a href="https://drupal-coding.com/drupal-seo" class="menulink"
              >РЕКЛАМА</a
            >
          </li>
          <li class="menuline">
            <div class="menulinewrapper">
              <a href="https://drupal-coding.com/team" class="menulink"
                >О НАС</a
              >
              <div class="triangle"></div>
            </div>
            <ul class="innermenu">
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/team#team"
                  class="menulink innermenulink"
                  >КОМАНДА</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/drupalgive"
                  class="menulink innermenulink"
                  >DRUPALGIVE</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/blog"
                  class="menulink innermenulink"
                  >БЛОГ</a
                >
              </li>
              <li class="innermenuline">
                <a
                  href="https://drupal-coding.com/drupal-courses"
                  class="menulink innermenulink"
                  >КУРСЫ DRUPAL</a
                >
              </li>
            </ul>
          </li>
          <li class="menuline"><a href="" class="menulink">ПРОЕКТЫ</a></li>
          <li class="menuline">
            <a href="https://drupal-coding.com/contacts" class="menulink"
              >КОНТАКТЫ</a
            >
          </li>
        </ul>
      </div>
    </header>
    <section class="preview">
      <div class="preview-bg">
        <video
          id="bg-video"
          autoplay="autoplay"
          loop=""
          preload="auto"
          muted=""
        >
          <source src="src/video.mp4" type="video/mp4" />
          Your browser does not support the video tag. I suggest you upgrade
          your browser.
        </video>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <h1 class="page-title">Поддержка сайтов на Drupal</h1>
            <div class="support-main-description">
              Сопровождение и поддержка сайтов <br />
              на CMS Drupal любых версий и запущенности
            </div>
            <div class="preview-wrapper">
              <a href="#plans" class="preview-btn">Тарифы</a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row achievements">
              <div class="col-md-4 col-sm-4 col-xs-6 achievement">
                <div class="achievement-wrapper">
                  <div class="achievement-title">
                    #1 <img alt="1 place" src="src/img/cup.png" />
                  </div>
                  <div class="achievement-description">
                    Drupal разработчик <br />
                    в России по версии <br />
                    Рейнтига Рунета
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 achievement">
                <div class="achievement-wrapper">
                  <div class="achievement-title">3+</div>
                  <div class="achievement-description">
                    Средний опыт<br />
                    специалистов <br />
                    более 3 лет
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 achievement">
                <div class="achievement-wrapper">
                  <div class="achievement-title">14</div>
                  <div class="achievement-description">
                    лет опыта в сфере <br />
                    Drupal
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 achievement">
                <div class="achievement-wrapper">
                  <div class="achievement-title">50+</div>
                  <div class="achievement-description">
                    Модулей и тем <br />
                    в формате DrupalGive
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 achievement">
                <div class="achievement-wrapper">
                  <div class="achievement-title">90 000+</div>
                  <div class="achievement-description">
                    часов поддержки <br />
                    сайтов на Drupal
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-sm-4 col-xs-6 achievement">
                <div class="achievement-wrapper">
                  <div class="achievement-title">300+</div>
                  <div class="achievement-description">
                    Проектов <br />
                    на поддержке
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section>
      <div class="ftp-56">
        <div class="competencies">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <h2 class="block-title">
                  13 лет совершенствуем <br />
                  компетенции в Друпал <br />
                  Поддержке
                </h2>
                <div class="competencies-description">
                  Разрабатываем и оптимизируем модули, расширяем <br />
                  функциональность сайтов, обновляем дизайн
                </div>
              </div>
            </div>
            <div class="row row-flex competencies-row">
              <div class="col-sm-3 col-xs-6">
                <div class="competency">
                  <div class="competency-wrapper">
                    <div class="competency-header">
                      <div class="competency-icon">
                        <img
                          alt=""
                          src="src/img/competency-1.svg"
                          class="img-responsive"
                        />
                      </div>
                    </div>
                    <div class="competency-body">
                      Добавление <br />
                      информации на сайт <br />
                      создание новых <br />
                      разделов
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-xs-6">
                <div class="competency">
                  <div class="competency-wrapper">
                    <div class="competency-header">
                      <div class="competency-icon">
                        <img
                          alt=""
                          src="src/img/competency-2.svg"
                          class="img-responsive"
                        />
                      </div>
                    </div>
                    <div class="competency-body">
                      Разработка <br />
                      и оптимизация <br />
                      модулей сайта
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-xs-6">
                <div class="competency">
                  <div class="competency-wrapper">
                    <div class="competency-header">
                      <div class="competency-icon">
                        <img
                          alt="Integration"
                          src="src/img/competency-3.svg"
                          class="img-responsive"
                        />
                      </div>
                    </div>
                    <div class="competency-body">
                      Интеграция с CRM, <br />
                      1C, платежными системами <br />
                      любыми веб-сервисами
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-xs-6">
                <div class="competency">
                  <div class="competency-wrapper">
                    <div class="competency-header">
                      <div class="competency-icon">
                        <img
                          alt="Design"
                          src="src/img/competency-4.svg"
                          class="img-responsive"
                        />
                      </div>
                    </div>
                    <div class="competency-body">
                      Любые доработки функционала <br />
                      и дизайна
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-xs-6">
                <div class="competency">
                  <div class="competency-wrapper">
                    <div class="competency-header">
                      <div class="competency-icon">
                        <img
                          alt="Security"
                          src="src/img/competency-5.svg"
                          class="img-responsive"
                        />
                      </div>
                    </div>
                    <div class="competency-body">
                      Аудит и мониторинг <br />
                      Безопасности Drupal сайтов
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-xs-6">
                <div class="competency">
                  <div class="competency-wrapper">
                    <div class="competency-header">
                      <div class="competency-icon">
                        <img
                          alt="Migration"
                          src="src/img/competency-6.svg"
                          class="img-responsive"
                        />
                      </div>
                    </div>
                    <div class="competency-body">
                      Миграция, импорт <br />
                      контента и апргейд <br />
                      Drupal
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-xs-6">
                <div class="competency">
                  <div class="competency-wrapper">
                    <div class="competency-header">
                      <div class="competency-icon">
                        <img
                          alt="Optimization"
                          src="src/img/competency-7.svg"
                          class="img-responsive"
                        />
                      </div>
                    </div>
                    <div class="competency-body">
                      Оптимизация <br />
                      и ускорение <br />
                      Drupal-сайтов
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3 col-xs-6">
                <div class="competency">
                  <div class="competency-wrapper">
                    <div class="competency-header">
                      <div class="competency-icon">
                        <img
                          alt="SEO"
                          src="src/img/competency-8.svg"
                          class="img-responsive"
                        />
                      </div>
                    </div>
                    <div class="competency-body">
                      Веб-маркетинг, <br />
                      консультации <br />
                      и работы по SEO
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="advantages with-expertise">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <h2 class="block-title">
                  Поддержка <br />
                  от Drupal-coder
                </h2>
              </div>
            </div>
            <div class="row row-flex advantages-row">
              <div class="col-sm-6 col-md-3 col-xs-12 advantage-col">
                <div class="advantage">
                  <div class="advantage-wrapper">
                    <div class="advantage-header">
                      <div class="advantage-num">01.</div>
                      <div class="advantage-title">
                        Постановка задачи по Email
                      </div>
                    </div>
                    <div class="advantage-body">
                      Удобная и привычная модель постановки задач, при которой
                      задачи фиксируются и никогда не теряются
                    </div>
                    <div class="advantage-icon">
                      <img
                        alt="Email"
                        src="src/img/support1.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-xs-12 advantage-col">
                <div class="advantage">
                  <div class="advantage-wrapper">
                    <div class="advantage-header">
                      <div class="advantage-num">02.</div>
                      <div class="advantage-title">
                        Система Helpdesk - отчетность, прозрачность
                      </div>
                    </div>
                    <div class="advantage-body">
                      Возможность просмотреть все заявки и отработанные часы в
                      личном кабинете через браузер.
                    </div>
                    <div class="advantage-icon">
                      <img
                        alt="Chart"
                        src="src/img/support2.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-xs-12 advantage-col">
                <div class="advantage">
                  <div class="advantage-wrapper">
                    <div class="advantage-header">
                      <div class="advantage-num">03.</div>
                      <div class="advantage-title">
                        Расширенная техническая поддержка
                      </div>
                    </div>
                    <div class="advantage-body">
                      Возможность организации расширенной техподдержки с 6:00 до
                      22:00 без выходных.
                    </div>
                    <div class="advantage-icon">
                      <img
                        alt="Extend"
                        src="src/img/support3.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-xs-12 advantage-col">
                <div class="advantage">
                  <div class="advantage-wrapper">
                    <div class="advantage-header">
                      <div class="advantage-num">04.</div>
                      <div class="advantage-title">
                        Персональный менеджер проекта
                      </div>
                    </div>
                    <div class="advantage-body">
                      CВаш менеджер проекта всегда в курсе текущего состояния
                      проекта и в любой момент готов ответить на любые вопросы.
                    </div>
                    <div class="advantage-icon">
                      <img
                        alt="User"
                        src="src/img/support4.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-xs-12 advantage-col">
                <div class="advantage">
                  <div class="advantage-wrapper">
                    <div class="advantage-header">
                      <div class="advantage-num">05.</div>
                      <div class="advantage-title">Удобные способы оплаты</div>
                    </div>
                    <div class="advantage-body">
                      Безналичный расчет по договору или электронные деньги:
                      WebMoney, Яндекс.Деньги, Paypal.
                    </div>
                    <div class="advantage-icon">
                      <img
                        alt="payments"
                        src="src/img/support5.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-xs-12 advantage-col">
                <div class="advantage">
                  <div class="advantage-wrapper">
                    <div class="advantage-header">
                      <div class="advantage-num">06.</div>
                      <div class="advantage-title">Работаем с SLA и NDA</div>
                    </div>
                    <div class="advantage-body">
                      Работа в рамках соглашений о конфиденциальности и об
                      уровне качества работ.
                    </div>
                    <div class="advantage-icon">
                      <img
                        alt="Doc"
                        src="src/img/support6.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-xs-12 advantage-col">
                <div class="advantage">
                  <div class="advantage-wrapper">
                    <div class="advantage-header">
                      <div class="advantage-num">07.</div>
                      <div class="advantage-title">Штатные специалисты</div>
                    </div>
                    <div class="advantage-body">
                      Надежные штатные специалисты, никаких фрилансеров.
                    </div>
                    <div class="advantage-icon">
                      <img
                        alt="Users"
                        src="src/img/support7.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-3 col-xs-12 advantage-col">
                <div class="advantage">
                  <div class="advantage-wrapper">
                    <div class="advantage-header">
                      <div class="advantage-num">08.</div>
                      <div class="advantage-title">Удобные каналы связи</div>
                    </div>
                    <div class="advantage-body">
                      Консультации по телефону, скайпу, в мессенджерах.
                    </div>
                    <div class="advantage-icon">
                      <img
                        alt="Questions"
                        src="src/img/support8.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="expertise">
          <div class="container">
            <div class="row">
              <div class="col-md-6 col-xs-12 col-md-offset-6">
                <div class="row">
                  <div class="col-md-12">
                    <h2 class="block-title">
                      Экспертиза в Drupal<br />опыт 14 лет!
                    </h2>
                  </div>
                </div>
                <div class="row row-flex expertise-row">
                  <div class="col-sm-6 col-xs-12 expertise-col">
                    <div class="expertise-item">
                      <div class="expertise-item-body">
                        Только системный подход - контроль версий, развертывание
                        и тестирование!
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xs-12 expertise-col">
                    <div class="expertise-item">
                      <div class="expertise-item-body">
                        Только Drupal сайты, не берем на поддержку сайты на
                        других CMS!
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xs-12 expertise-col">
                    <div class="expertise-item">
                      <div class="expertise-item-body">
                        Участвуем в разработке ядра Drupal и модулей на
                        Drupal.org. разрабатываем свои модули Drupal
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-xs-12 expertise-col">
                    <div class="expertise-item">
                      <div class="expertise-item-body">
                        Поддерживаем сайты на Drupal 5, 6, 7 и 8
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="expertise-img">
            <img
              alt="helpdesk"
              class="img-responsive"
              src="src/img/laptop.png"
            />
          </div>
        </div>
      </div>
    </section>
    <section id="plans" class="block clear">
      <h2 class="block-title">Тарифы</h2>

      <div class="ftp-56">
        <div class="tariffs">
          <div class="container">
            <div class="row row-flex tariffs-row">
              <div class="col-sm-4 col-xs-12 col-flex">
                <div class="tariff">
                  <div class="tariff-wrapper">
                    <div class="tariff-header">
                      <div class="tariff-title">Стартовый</div>
                      <br />
                    </div>
                    <div class="tariff-body">
                      <div class="tarrif-body-item">
                        &check; Консультация и работы по SEO
                      </div>
                      <div class="tarrif-body-item">
                        &check; Услуги дизайнера
                      </div>
                      <div class="tarrif-body-item">
                        &check; Неиспользованные оплаченые часы переносятся на
                        следующий месяц
                      </div>
                      <div class="tarrif-body-item">
                        &check; Предоплата от 6 000 рублей в месяц
                      </div>
                    </div>
                    <div class="tariff-footer">
                      <a
                        href="#support"
                        class="contact-form tariff-footer-btn"
                        tabindex="-1"
                        >Свяжитесь с нами!</a
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-flex col-xs-12">
                <div class="tariff">
                  <div class="tariff-wrapper">
                    <div class="tariff-header">
                      <div class="tariff-title">Бизнес</div>
                      <br />
                    </div>
                    <div class="tariff-body">
                      <div class="tarrif-body-item">
                        &check; Консультация и работы по SEO
                      </div>
                      <div class="tarrif-body-item">
                        &check; Услуги дизайнера
                      </div>
                      <div class="tarrif-body-item">
                        &check; Высокое время реации - до 2 рабочих дней
                      </div>
                      <div class="tarrif-body-item">
                        &check; Неиспользованные оплаченые часы переносятся на
                        следующий месяц
                      </div>
                      <div class="tarrif-body-item">
                        &check; Предоплата от 30 000 рублей в месяц
                      </div>
                    </div>
                    <div class="tariff-footer">
                      <a
                        href="#support"
                        class="contact-form tariff-footer-btn"
                        tabindex="-1"
                        >Свяжитесь с нами!</a
                      >
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-4 col-flex col-xs-12">
                <div class="tariff">
                  <div class="tariff-wrapper">
                    <div class="tariff-header">
                      <div class="tariff-title">VIP</div>
                      <br />
                    </div>
                    <div class="tariff-body">
                      <div class="tarrif-body-item">
                        &check; Консультация и работы по SEO
                      </div>
                      <div class="tarrif-body-item">
                        &check; Услуги дизайнера
                      </div>
                      <div class="tarrif-body-item">
                        &check; Максимальное время реации - в день обращения
                      </div>
                      <div class="tarrif-body-item">
                        &check; Неиспользованные оплаченые часы переносятся на
                        следующий месяц
                      </div>
                      <div class="tarrif-body-item">
                        &check; Предоплата от 270 000 рублей в месяц
                      </div>
                    </div>
                  </div>
                  <div class="tariff-footer">
                    <a
                      href="#support"
                      class="contact-form tariff-footer-btn"
                      tabindex="-1"
                      >Свяжитесь с нами!</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12">
            <div class="tariffs-ps">
              Вам не подходят наши тарифы? Оставьте заявку и ы предложим вам
              индивидуальные условия!
              <a href="#support" class="tariffs-link"
                >Получить индивидуальный тариф</a
              >
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="views-element-container container block block-views clear">
      <div class="competencies">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <h2 class="block-title">
                Наши профессиональные разработчики выполняют быстро любые задачи
              </h2>
            </div>
          </div>
          <div class="row row-flex competencies-row">
            <div class="col-sm-3 col-xs-6">
              <div class="competency">
                <div class="competency-wrapper">
                  <div class="competency-header">
                    <div class="competency-icon">
                      <img
                        alt=""
                        src="src/img/competency-20.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                  <div class="competency-body">
                    Добавление <br />
                    информации на сайт <br />
                    создание новых <br />
                    разделов
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="competency">
                <div class="competency-wrapper">
                  <div class="competency-header">
                    <div class="competency-icon">
                      <img
                        alt=""
                        src="src/img/competency-21.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                  <div class="competency-body">
                    Разработка <br />
                    и оптимизация <br />
                    модулей сайта
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3 col-xs-6">
              <div class="competency">
                <div class="competency-wrapper">
                  <div class="competency-header">
                    <div class="competency-icon">
                      <img
                        alt="Integration"
                        src="src/img/competency-22.svg"
                        class="img-responsive"
                      />
                    </div>
                  </div>
                  <div class="competency-body">
                    Интеграция с CRM, <br />
                    1C, платежными системами <br />
                    любыми веб-сервисами
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section
      class="views-element-container container block block-views block-views-blockteam-team-new clear"
      id="block-views-block-team-new"
    >
      <h2 class="block-title">Команда</h2>

      <div class="form-group">
        <div class="text-center">
          <div class="view-content">
            <div class="col-xs-6 col-sm-6 col-md-4 views-row">
              <article typeof="schema:Person" class="user-teaser">
                <div class="photo">
                  <img
                    loading="eager"
                    width="280"
                    height="280"
                    src="src/img/IMG_2472_0.jpg"
                    alt="Profile picture for user Сергей Синица"
                    typeof="foaf:Image"
                  />
                </div>

                <div class="emp-name">Сергей Синица</div>
                <div class="emp-post field--name-field-post">
                  Руководитель отдела веб-разработки, канд. техн. наук,
                  заместитель директора
                </div>
              </article>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-4 views-row">
              <article typeof="schema:Person" class="user-teaser">
                <div class="photo field--name-user-picture field--type-image">
                  <img
                    loading="eager"
                    width="280"
                    height="280"
                    src="src/img/IMG_2539_0.jpg"
                    alt="Profile picture for user Roman Agabekov"
                    typeof="foaf:Image"
                  />
                </div>
                <div class="emp-name">Роман Агабеков</div>
                <div class="emp-post field--name-field-post">
                  Руководитель отдела DevOPS, директор
                </div>
              </article>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-4 views-row">
              <article typeof="schema:Person" class="user-teaser">
                <div class="photo field--name-user-picture field--type-image">
                  <img
                    loading="eager"
                    width="280"
                    height="280"
                    src="src/img/IMG_2474_1.jpg"
                    alt="Profile picture for user Алексей Синица"
                    typeof="foaf:Image"
                  />
                </div>
                <div class="emp-name">Алексей Синица</div>
                <div class="emp-post field--name-field-post">
                  Руководитель отдела поддержки сайтов
                </div>
              </article>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-4 views-row">
              <article typeof="schema:Person" class="user-teaser">
                <div class="photo field--name-user-picture field--type-image">
                  <img
                    loading="eager"
                    width="280"
                    height="280"
                    src="src/img/IMG_2522_0.jpg"
                    alt="Profile picture for user d.Bochkareva"
                    typeof="foaf:Image"
                  />
                </div>
                <div class="emp-name">Дарья Бочкарёва</div>
                <div class="emp-post field--name-field-post">
                  Руководитель отдела продвижения, контекстной рекламы и
                  контент-поддержки сайтов
                </div>
              </article>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-4 views-row">
              <article typeof="schema:Person" class="user-teaser">
                <div class="photo field--name-user-picture field--type-image">
                  <img
                    loading="eager"
                    width="280"
                    height="280"
                    src="src/img/IMG_9971_16.jpg"
                    alt="Profile picture for user Ирина"
                    typeof="foaf:Image"
                  />
                </div>
                <div class="emp-name">Ирина Торкунова</div>
                <div class="emp-post field--name-field-post">
                  Менеджер по работе с клиентами
                </div>
              </article>
            </div>
          </div>
          <div class="more-link form-group">
            <a href="https://drupal-coding.com/team">Вся команда</a>
          </div>
        </div>
      </div>
    </section>
    <section
      class="views-element-container container block block-views block-views-blockkeys-block-1 clear"
      id="block-views-block-keys-block"
    >
      <h2 class="block-title">Последние кейсы</h2>

      <div class="form-group">
        <div class="view view-keys view-id-keys view-display-id-block_1">
          <div class="view-content">
            <article class="blog is-promoted keys-1 clear">
              <div class="keys-1__wrapper">
                <div class="keys-1__picture">
                  <div class="field--name-field-blog-img field--type-image">
                    <picture>
                      <img
                        width="840"
                        height="475"
                        src="src/img/article1.png"
                        alt="Data cache"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                </div>

                <div class="keys-1__container">
                  <div class="keys-1__header">
                    <h2>
                      <a rel="bookmark">
                        <span
                          >Настройка кеширования данных. Апгрейд сервера.
                          Ускорение работы сайта в 30 раз!</span
                        >
                      </a>
                    </h2>

                    <div class="keys-1__header-date">04.05.2020</div>
                  </div>

                  <div class="keys-1__content">
                    <div class="ftp-56">
                      <p>
                        Влияние скорости загрузки страниц сайта на отказы и
                        конверсии. Кейс ускорения...
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </article>

            <article class="blog is-promoted keys-2 clear">
              <div class="keys-2__wrapper">
                <div class="keys-2__picture">
                  <div class="field--name-field-blog-img field--type-image">
                    <picture>
                      <img
                        loading="eager"
                        sizes="max-width:767px"
                        width="700"
                        height="360"
                        src="src/img/article2.jpg"
                        alt="Ecommerce metrics"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                </div>

                <div class="keys-2__container">
                  <div class="keys-2__header">
                    <h2>
                      <a href="" rel="bookmark">
                        <span
                          >Использование отчётов Ecommerce в
                          Яндекс.Метрике</span
                        >
                      </a>
                    </h2>
                  </div>

                  <div class="keys-2__content"></div>
                </div>
              </div>
            </article>

            <article class="blog is-promoted keys-1 clear">
              <div class="keys-1__wrapper">
                <div class="keys-1__picture">
                  <div class="field--name-field-blog-img field--type-image">
                    <picture>
                      <img
                        loading="eager"
                        width="840"
                        height="475"
                        src="src/img/article3.png"
                        alt="Conversion Improvement"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                </div>

                <div class="keys-1__container">
                  <div class="keys-1__header">
                    <h2>
                      <a href="" rel="bookmark">
                        <span
                          >Повышение конверсии страницы с формой заявки с
                          применением AB-тестирования</span
                        >
                      </a>
                    </h2>

                    <div class="keys-1__header-date">24.01.2020</div>
                  </div>

                  <div class="keys-1__content"></div>
                </div>
              </div>
            </article>

            <article class="blog is-promoted keys-1 clear">
              <div class="keys-1__wrapper">
                <div class="keys-1__picture">
                  <div class="field--name-field-blog-img field--type-image">
                    <picture>
                      <img
                        loading="eager"
                        width="840"
                        height="475"
                        src="src/img/article4.jpg"
                        alt="Drupal 7 acceleration"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                </div>

                <div class="keys-1__container">
                  <div class="keys-1__header">
                    <h2>
                      <a href="" rel="bookmark">
                        <span
                          >Drupal 7: ускорение времени генерации страниц
                          интернет-магазина на 32%</span
                        >
                      </a>
                    </h2>

                    <div class="keys-1__header-date">23.09.2019</div>
                  </div>

                  <div class="keys-1__content"></div>
                </div>
              </div>
            </article>

            <article class="blog is-promoted keys-1 clear">
              <div class="keys-1__wrapper">
                <div class="keys-1__picture">
                  <div class="field--name-field-blog-img field--type-image">
                    <picture>
                      <img
                        loading="eager"
                        width="840"
                        height="475"
                        src="src/img/article5.png"
                        alt="business-online"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                </div>

                <div class="keys-1__container">
                  <div class="keys-1__header">
                    <h2>
                      <a href="" rel="bookmark">
                        <span
                          >Обмен товарами и заказами интернет-магазинов на
                          Drupal 7 с 1С: Предприятие, МойСклад, Класс365</span
                        >
                      </a>
                    </h2>

                    <div class="keys-1__header-date">22.08.2019</div>
                  </div>

                  <div class="keys-1__content">
                    <div class="ftp-56"><p>Опубликован релиз модуля...</p></div>
                  </div>
                </div>
              </div>
            </article>
          </div>
        </div>
      </div>
    </section>
    <section
      class="views-element-container block block-views block-views-blocktestimonials-block-1 clear"
      id="block-views-block-testimonials-block-1"
    >
      <h2 class="block-title">Отзывы</h2>

      <div class="form-group">
        <div
          class="container view view-testimonials view-id-testimonials view-display-id-block_1"
        >
          <div class="view-content">
            <div class="slick">
              <div id="slick-review">
                <div class="">
                  <div class="views-field-field-project-logo">
                    <div class="field-content">
                      <img
                        src="src/img/logo_0.png"
                        width="78"
                        height="46"
                        alt="Ciel parfum"
                        typeof="foaf:Image"
                      />
                    </div>
                  </div>
                  <div class="views-field views-field-field-report-text">
                    <div class="field-content">
                      Долгие поиски единственного и неповторимого мастера на
                      многострадальный сайт www.cielparfum.com, который был
                      собран крайне некомпетентным программистом и раз в месяц
                      стабильно грозил погибнуть, привели меня на сайт и, в
                      итоге, к ребятам из Drupal-coder. И вот уже практически
                      полгода как не проходит и дня, чтобы я не поудивлялась и
                      не порадовалась своему везению! Починили все, что не
                      работало - от поиска до отображения меню. Провели редизайн
                      - не отходя от желаемого, но со своими существенными и
                      качественными дополнениями. Осуществили ряд проектов -
                      конкурсы, тесты и тд. А уж мелких починок и доработок - не
                      счесть! И главное - все качественно и быстро (не взирая на
                      не самый "быстрый" тариф). Есть вопросы - замечательный
                      Алексей всегда подскажет, поддержит, отремонтирует и/или
                      просто сделает с нуля. Есть задумка для реализации -
                      замечательный Сергей обсудит и предложит идеальный
                      вариант. Есть проблема - замечательные Надежда и Роман
                      починят, поправят, сделают! Ребята доказали, что эта CMS -
                      мощная и грамотная система управления. Надеюсь, что наше
                      сотрудничество затянется надолго! Спасибо!!!
                    </div>
                  </div>
                  <div class="views-field views-field-field-report-author">
                    <div class="field-content">
                      С уважением, Наталья Сушкова руководитель Отдела
                      веб-проектов Группы компаний «Си Эль парфюм»
                      <a href="http://www.cielparfum.com/" tabindex="0"
                        >http://www.cielparfum.com/</a
                      >
                    </div>
                  </div>
                </div>

                <div class="">
                  <div class="views-field-field-project-logo">
                    <div class="field-content">
                      <img
                        src="src/img/logo_0.png"
                        width="78"
                        height="46"
                        alt="Ciel parfum"
                        typeof="foaf:Image"
                      />
                    </div>
                  </div>
                  <div class="views-field views-field-field-report-text">
                    <div class="field-content">Sample Text2</div>
                  </div>
                  <div class="views-field views-field-field-report-author">
                    <div class="field-content">By lorem</div>
                  </div>
                </div>
                <div class="">
                  <div class="views-field-field-project-logo">
                    <div class="field-content">
                      <img
                        src="src/img/logo_0.png"
                        width="78"
                        height="46"
                        alt="Ciel parfum"
                        typeof="foaf:Image"
                      />
                    </div>
                  </div>
                  <div class="views-field views-field-field-report-text">
                    <div class="field-content">Sample Text3</div>
                  </div>
                  <div class="views-field views-field-field-report-author">
                    <div class="field-content">By lorem</div>
                  </div>
                </div>
                <div class="">
                  <div class="views-field-field-project-logo">
                    <div class="field-content">
                      <img
                        src="src/img/logo_0.png"
                        width="78"
                        height="46"
                        alt="Ciel parfum"
                        typeof="foaf:Image"
                      />
                    </div>
                  </div>
                  <div class="views-field views-field-field-report-text">
                    <div class="field-content">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                      Consequatur cum ducimus neque totam, ut voluptatum? Ab
                      accusantium dolor ducimus fugiat harum hic in magni,
                      obcaecati quas, quisquam quo rem repudiandae soluta
                      tempore unde veritatis voluptatibus. Distinctio doloremque
                      ea eos est, explicabo id ipsa iste perspiciatis vel? Alias
                      doloribus expedita maxime modi sit? Ab, ad animi at beatae
                      consequatur consequuntur dolor dolore dolores, doloribus
                      dolorum ducimus eos esse illo in incidunt ipsa ipsam ipsum
                      itaque iure laudantium libero, modi non odio optio
                      perferendis praesentium provident quae quas quidem quis
                      recusandae rem sed sequi sunt tempore vel vitae? Beatae
                      excepturi libero non.
                    </div>
                  </div>
                  <div class="views-field views-field-field-report-author">
                    <div class="field-content">By lorem</div>
                  </div>
                </div>
              </div>
              <nav role="navigation" class="slick__arrow">
                <button
                  type="button"
                  class="review-arrow-prev slick-prev slick-arrow"
                  aria-label="Previous"
                  style=""
                >
                  Previous
                </button>
                <span class="slick-review-total"
                  ><span class="slick-review-counter">01/ </span></span
                >
                <button
                  type="button"
                  class="review-arrow-next slick-next slick-arrow"
                  aria-label="Next"
                  style=""
                >
                  Next
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section
      class="views-element-container block block-views block-views-blockour-clients-block-1 clear"
      id="block-views-block-our-clients"
    >
      <h2 class="block-title">С нами работают</h2>

      <div class="form-group">
        <div class="view view-our-clients">
          <div class="view-header">
            Десятки компаний доверяют нам самое ценное, что у них есть в
            интернете - свои сайты. Мы делаем всё, чтобы наше сотрудничество
            было долгим.
          </div>

          <div class="view-content">
            <div class="slick" data-blazy="" data-once="blazy slick">
              <div aria-live="polite" class="slick slick-list draggable">
                <div
                  id="slick-customers-first"
                  class="slick-customers slick-track"
                  role="listbox"
                >
                  <div
                    class="slick__slide slide slide--1 slick-slide"
                    data-slick-index="3"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide21"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="src/img/kubsu.jpeg"
                        alt="japantravel.ru"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>

                  <div
                    class="slick__slide slide slide--3 slick-slide"
                    data-slick-index="3"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide23"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="Ciel parfum"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>

                  <div
                    class="slick__slide slide slide--2 slick-slide"
                    data-slick-index="2"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide22"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="http://lpcma.tsu.ru/en"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--3 slick-slide"
                    data-slick-index="3"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide23"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="arsa.su"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--4 slick-slide slick-active"
                    data-slick-index="4"
                    aria-hidden="false"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide24"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="vekas-automation.ru"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--5 slick-slide slick-active"
                    data-slick-index="5"
                    aria-hidden="false"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide25"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="megafurs.com"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--6 slick-slide slick-current slick-active slick-center"
                    data-slick-index="6"
                    aria-hidden="false"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide26"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="japantravel.ru"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--7 slick-slide slick-active"
                    data-slick-index="7"
                    aria-hidden="false"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide27"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="confirent.ru"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--8 slick-slide slick-active"
                    data-slick-index="8"
                    aria-hidden="false"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide28"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="urheiluperhe.com"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--9 slick-slide"
                    data-slick-index="9"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide29"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="ayurvedadom.com"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--10 slick-slide"
                    data-slick-index="10"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide210"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="angel-estate.ru"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--11 slick-slide"
                    data-slick-index="11"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                    role="option"
                    aria-describedby="slick-slide211"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="http://artzacepka.ru/"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--0 slick-slide slick-cloned"
                    data-slick-index="12"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="http://andreyparabellum.ru "
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--1 slick-slide slick-cloned"
                    data-slick-index="13"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="Ciel parfum"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--2 slick-slide slick-cloned"
                    data-slick-index="14"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="http://lpcma.tsu.ru/en"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                  <div
                    class="slick__slide slide slide--3 slick-slide slick-cloned"
                    data-slick-index="15"
                    aria-hidden="true"
                    style="width: 310px"
                    tabindex="-1"
                  >
                    <picture>
                      <img
                        loading="eager"
                        srcset="src/img/kubsu.jpeg"
                        width="290"
                        height="155"
                        src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        alt="arsa.su"
                        typeof="foaf:Image"
                      />
                    </picture>
                  </div>
                </div>
              </div>
            </div>
            <nav role="navigation" class="slick__arrow">
              <div class="slick__arrow-wrapper">
                <button
                  type="button"
                  data-role="none"
                  class="slick-prev visually-hidden"
                  aria-label="Previous"
                  tabindex="0"
                >
                  Previous
                </button>
                <span class="slick-slide-num"></span>
                <button
                  type="button"
                  data-role="none"
                  class="slick-next visually-hidden"
                  aria-label="Next"
                  tabindex="0"
                >
                  Next
                </button>
              </div>
            </nav>
          </div>
        </div>

        <div class="view-content">
          <div class="slick" data-blazy="" data-once="blazy slick">
            <div
              aria-live="polite"
              class="slick slick-list draggable"
              style="padding: 0px 10%"
            >
              <div
                id="slick-customers-second"
                class="slick-customers slick-track"
                style="transform: scaleX(130%)"
                role="listbox"
              >
                <div
                  class="slick__slide slide slide--1 slick-slide"
                  data-slick-index="3"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide21"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="src/img/kubsu.jpeg"
                      alt="japantravel.ru"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>

                <div
                  class="slick__slide slide slide--3 slick-slide"
                  data-slick-index="3"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide23"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="Ciel parfum"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>

                <div
                  class="slick__slide slide slide--2 slick-slide"
                  data-slick-index="2"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide22"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="http://lpcma.tsu.ru/en"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--3 slick-slide"
                  data-slick-index="3"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide23"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="arsa.su"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--4 slick-slide slick-active"
                  data-slick-index="4"
                  aria-hidden="false"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide24"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="vekas-automation.ru"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--5 slick-slide slick-active"
                  data-slick-index="5"
                  aria-hidden="false"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide25"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="megafurs.com"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--6 slick-slide slick-current slick-active slick-center"
                  data-slick-index="6"
                  aria-hidden="false"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide26"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="japantravel.ru"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--7 slick-slide slick-active"
                  data-slick-index="7"
                  aria-hidden="false"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide27"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="confirent.ru"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--8 slick-slide slick-active"
                  data-slick-index="8"
                  aria-hidden="false"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide28"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="urheiluperhe.com"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--9 slick-slide"
                  data-slick-index="9"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide29"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="ayurvedadom.com"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--10 slick-slide"
                  data-slick-index="10"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide210"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="angel-estate.ru"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--11 slick-slide"
                  data-slick-index="11"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                  role="option"
                  aria-describedby="slick-slide211"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="http://artzacepka.ru/"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--0 slick-slide slick-cloned"
                  data-slick-index="12"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="http://andreyparabellum.ru "
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--1 slick-slide slick-cloned"
                  data-slick-index="13"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="Ciel parfum"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--2 slick-slide slick-cloned"
                  data-slick-index="14"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="http://lpcma.tsu.ru/en"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
                <div
                  class="slick__slide slide slide--3 slick-slide slick-cloned"
                  data-slick-index="15"
                  aria-hidden="true"
                  style="width: 310px"
                  tabindex="-1"
                >
                  <picture>
                    <img
                      loading="eager"
                      srcset="src/img/kubsu.jpeg"
                      width="290"
                      height="155"
                      src="data:image/gif;base64,R0lGODlhAQABAIABAP///wAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      alt="arsa.su"
                      typeof="foaf:Image"
                    />
                  </picture>
                </div>
              </div>
            </div>
          </div>
          <nav role="navigation" class="slick__arrow">
            <div class="slick__arrow-wrapper">
              <button
                type="button"
                data-role="none"
                class="slick-prev visually-hidden"
                aria-label="Previous"
                tabindex="0"
              >
                Previous
              </button>
              <span class="slick-slide-num"></span>
              <button
                type="button"
                data-role="none"
                class="slick-next visually-hidden"
                aria-label="Next"
                tabindex="0"
              >
                Next
              </button>
            </div>
          </nav>
        </div>
      </div>
    </section>
    <section
      id="block-faq"
      class="dc-section faq-block block block-block-content clearfix"
    >
      <h2 class="block-title faq-title">FAQ</h2>

      <div
        class="field field--name-body field--type-text-with-summary field--label-hidden field--item"
      >
        <div class="container">
          <div class="panel-group panel-faq" id="accordion">
            <div class="panel panel-default panel_open">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Кто непосредственно занимается поддержкой?
                  </a>
                </h4>
              </div>
              <div class="panel-body">
                Сайты поддерживают штатные сотрудники ООО «Инитлаб», г.
                Краснодар, прошедшие специальное обучение и имеющие опыт работы
                с Друпал от 4 до 15 лет: 8 web-разработчиков, 2 специалиста по
                SEO, 4 системных администратора.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn">Как организована работа поддержки? </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Что происходит, когда отработаны все предоплаченные часы?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Что происходит, когда не отработы предоплаченные часы за
                    месяц?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Как происходит оценка и согласование планируемого времени
                    на выполнение заявок?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Сколько программистов выделяется на проект?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Как подать заявку на внесение изменений на сайте?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Как подать заявку на добавление пользователя, изменение
                    настроек веб-сервера и других задач по администрированию?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >В течение какого времени начинается работа по заявке?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn">В какое время работает поддержка? </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Подходят ли услуги поддержки, если необходимо произвести
                    обновление ядра Drupal или модулей?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
            <div class="panel panel-default panel_close">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a class="panel-btn"
                    >Можно ли пообщаться со специалистом голосом или в
                    мессенджере?
                  </a>
                </h4>
              </div>
              <div class="panel-body" style="display: none">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi
                aut officia qui quos suscipit? A aspernatur atque culpa delectus
                dolor, dolorem ea fugit impedit maiores natus optio placeat
                suscipit, ut. A ad, amet asperiores at consequatur in laudantium
                maxime nam officia qui quia, repellat sapiente sed sint
                voluptas, voluptatem voluptates.
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <footer class="footer" role="contentinfo">
      <div class="container">
        <div>
          <section class="block clear" id="support">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="field ftp-56">
                        <div class="block-form-wrapper">
                            <div class="block-form-title">
                                Оставить заявку на <br />поддержку сайта
                            </div>

                            <div class="block-form-description">
                                Срочно нужна поддержка сайта? Ваша команда не успевает
                                справиться самостоятельно или предыдущий подрядчик не
                                справится с работой? Тогда вам точно к нам! Просто
                                оставьте заявку и наш менеджер с вами свяжется!
                            </div>

                            <div class="block-form-contacts">
                                <ul>
                                    <li class="block-form-phone">
                                        <a href="tel:8800222-26-73">&#9742;8 800 222-26-73</a>
                                    </li>
                                    <li class="block-form-email">
                                        <a href="mailto:sales@drupal-coding.com"
                                            >&#9993;info@drupal-coder.ru</a
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-6">
                    <div class="field form-container">
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <div class="logout-container">
                            <span>Welcome, <?= htmlspecialchars($_SESSION['user_login'] ?? 'User') ?></span>
                            <a href="?logout=1" class="logout-btn">Logout</a>
                        </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                        <div class="success-message">
                            <p>Data has been saved successfully!</p>
                            <?php if (isset($_SESSION['generated_credentials'])): ?>
                                <p>
                                    Your login: <strong><?= htmlspecialchars($_SESSION['generated_credentials']['login']) ?></strong>
                                </p>
                                <p>
                                    Your password: <strong><?= htmlspecialchars($_SESSION['generated_credentials']['password']) ?></strong>
                                </p>
                                <p class="warning-note">
                                    (Please save this information, the password cannot be recovered)
                                </p>
                                <p>You can log in</p><a href="index.php">here</a>
                                <?php unset($_SESSION['generated_credentials']); ?>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <?php if($update_success): ?>
                            <div class = "update_success_message">
                                Your data has been updated
                            </div>
                        <?php endif;?>

                        <?php if (!empty($errors)): ?>
                            <div class="error-message">
                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                        <li class="error"><?= htmlspecialchars(is_array($error) ? implode('<br>', $error) : $error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="database.php" method="post">
                            <div class="form-group">
                                <div class="form-item form-type-textfield form-group">
                                    <label for="name" class="control-label">Ваше имя</label>
                                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($form_data['name']) ?>" 
                                           class="form-text form-control <?= isset($errors['name']) ? 'error-field' : '' ?>"
                                            <?= $success ? 'disabled' : '' ?>>
                                    <?php if (isset($errors['name'])): ?>
                                        <div class="error"><?= htmlspecialchars($errors['name']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group" id="form-phone-wrapper">
                                <div class="form-item js-form-item form-type-textfield form-group">
                                    <label for="phone" class="control-label">Телефон</label>
                                    <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($form_data['phone']) ?>" 
                                           class="form-text form-control <?= isset($errors['phone']) ? 'error-field' : '' ?>"
                                           <?= $success ? 'disabled' : '' ?>>
                                    <?php if (isset($errors['phone'])): ?>
                                        <div class="error"><?= htmlspecialchars($errors['phone']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-item form-type-email form-group">
                                    <label for="mail" class="control-label">E-mail</label>
                                    <input type="email" name="mail" id="mail" value="<?= htmlspecialchars($form_data['mail']) ?>" 
                                           class="form-email form-control <?= isset($errors['mail']) ? 'error-field' : '' ?>"
                                           <?= $success ? 'disabled' : '' ?>>
                                    <?php if (isset($errors['mail'])): ?>
                                        <div class="error"><?= htmlspecialchars($errors['mail']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-item form-group">
                                    <label for="bdate" class="control-label">Дата рождения</label>
                                    <input type="date" name="bdate" id="bdate" value="<?= htmlspecialchars($form_data['bdate']) ?>" 
                                            class="form-control <?= isset($errors['birth']) ? 'error-field' : '' ?>"
                                            <?= $success ? 'disabled' : '' ?>>
                                    <?php if (isset($errors['bdate'])): ?>
                                        <div class="error"><?= htmlspecialchars($errors['birth']) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Пол</label>
                                <div class="radio_container" id="gender_choice">
                                    <input type="radio" id="male" name="gender" value="male" 
                                           <?= $form_data['gender'] === 'male' ? 'checked' : '' ?>
                                           <?= $success ? 'disabled' : '' ?>>
                                    <label for="male">Мужской</label>

                                    <input type="radio" id="female" name="gender" value="female" 
                                           <?= $form_data['gender'] === 'female' ? 'checked' : '' ?>
                                           <?= $success ? 'disabled' : '' ?>>
                                    <label for="female">Женский</label>
                                </div>
                                <?php if (isset($errors['gender'])): ?>
                                    <div class="error"><?= htmlspecialchars($errors['gender']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="languages" class="control-label">Языки программирования</label>
                                <select name="languages[]" id="languages" multiple class="form-control <?= isset($errors['languages']) ? 'error-field' : '' ?>"
                                <?= $success ? 'disabled' : '' ?>>
                                    <?php
                                    $all_languages = ['C++', 'Pascal', 'C', 'JavaScript', 'PHP', 'Python', 'Java', 'Haskell', 'Clojure', 'Prolog', 'Scala', 'Go'];
                                    foreach ($all_languages as $lang): ?>
                                        <option value="<?= htmlspecialchars($lang) ?>" 
                                                <?= in_array($lang, $form_data['languages']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($lang) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (isset($errors['languages'])): ?>
                                    <div class="error"><?= htmlspecialchars($errors['languages']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group">
                                <label for="bio" class="control-label">О себе</label>
                                <textarea name="bio" id="bio" rows="5" cols="30" 
                                          class="form-control <?= isset($errors['bio']) ? 'error-field' : '' ?>"
                                          <?= $success ? 'disabled' : '' ?>>
                                          <?= htmlspecialchars($form_data['bio']) ?>
                                </textarea>
                                <?php if (isset($errors['bio'])): ?>
                                    <div class="error"><?= htmlspecialchars($errors['bio']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-type-checkbox checkbox">
                                <label for="contract" class="control-label option">
                                    <input type="checkbox" name="contract" id="contract"
                                    <?= $success ? 'checked disabled' : '' ?>>
                                    Я согласен на обработку персональных данных
                                </label>
                                <?php if (isset($errors['contract'])): ?>
                                    <div class="error"><?= htmlspecialchars($errors['contract']) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group" id="edit-actions">
                                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']):?>
                                    <button class="btn" type="submit" id="edit-submit" name="op" value="Contact Us">
                                        Обновить данные
                                    </button>
                                <?php elseif(!$success):?>
                                    <button class="btn" type="submit" id="edit-submit" name="op" value="Contact Us">
                                        Отправить
                                    </button>
                                <?php endif;?>
                            </div>
                        </form>

                        <div class="login-section" style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
    <h3 style="margin-bottom: 15px;">Уже зарегистрированы? Войдите в систему</h3>
    
    <?php if(!empty($_SESSION['login_error'])): ?>
        <div class="login-error" style="color: red; margin-bottom: 15px;">
            <?= htmlspecialchars($_SESSION['login_error']) ?>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
    
    <form action="auth.php" method="POST" id="login-form">
        <div class="form-group">
            <label for="login-username">Логин</label>
            <input type="text" name="login" id="login-username" required class="form-control">
        </div>
        
        <div class="form-group">
            <label for="login-password">Пароль</label>
            <input type="password" name="password" id="login-password" required class="form-control">
        </div>
        
        <button type="submit" class="btn">Войти</button>
    </form>
</div>

                    </div>
                </div>
            </div>
        </div>
    </section>

          <section id="block-copyright" class="block clear">
            <div class="fpt-56">
              <p>
                Проект ООО «Инитлаб», Краснодар, Россия. <br />
                Drupal является зарегистрированной торговой маркой Dries
                Buytaert.
              </p>
            </div>
          </section>
        </div>
      </div>
    </footer>
  </body>
</html>
