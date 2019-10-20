<?php
   include("config.php");
   session_start();

?>
<?php
date_default_timezone_set("Australia/Melbourne");
if (isset($_POST['submit']) || isset($_POST['search'])) {
    //if submit is push without datas in the search bar, reload index.php and get message
    if (empty($_POST['search'])) {
        header("location: index.php?=");
    } else {
        //Search word
        $post = trim(htmlentities(ucfirst($_POST['search'])));
        $_SESSION['search'] = $post;
        //Get datas from http request to openweathermap
        $jsonMeteo = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q=' . $_SESSION['search'] . '&&apikey=0f418ac72af1b1183f22b0aadded77ab&units=metric&lang=fr');
        //if submit nothing corresponding from the cities list, reload index.php and get message
        if (!$jsonMeteo) {
            header("location: index.php" . $_SESSION['search']);
        } else {
            $meteo = json_decode($jsonMeteo, true);
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
  <head>
      <title>Weather App</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     <link rel="stylesheet" type="text/css" href="css/style.css">
  </head>
  <body>
      <?php include("navigation.php")?>
      <div class="container">
          <div id="visual" style = "height: 350px">
                <div class="row no-gutters justify-content-around">
                    <div class="col-12 col-md-4 tuile my-3 text-center mr-1 d-flex" style="float: right">
                        <div class="align-self-center mx-auto">
                            <h1>Live weather data for your city </h1>
                            <p>Today's Date: <?php echo date('d/m/Y   @H:i:s') ?> </p/>
                            <form class="form-inline" method="POST" action="index.php">
                                <div class="input-group mx-auto">
                                    <input class="form-control" type="text" name="search" id="search"
                                           placeholder="Melbourne">
                                    <button type="submit" class="btn btn-secondary btn-lg mt-0">Search</button>
                                </div>
                            </form>
                            <p>
                                <span class="queryDate"> Last updated : <?php echo date('h') . ' : ' . date('i') . ' : ' . date('s') . '  ' . date(A)?></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 tuile my-3 text-center ml-1 d-flex">
                        <div class="align-self-center mx-auto">
                            <div class="row no-gutters">
                              <div class="col-2 hover"></div>
                                <div class="col-7">
                                    <h1 style="margin-top: -75;">Current weather in <?php echo $meteo['name'] . ' ' . $meteo['sys']['country'] ?></h1>
                                </div>
                                <div class="col-3 hover"></div>
                                <div class="col-4 hover">
                                    <?php
                                    echo '<h3>Temperature ' . $meteo['main']['temp'] . '°C</h3>';
                                    ?>
                                </div>
                                <div class="col-3 hover">
                                    <?php
                                    echo '<h3>Humidity     ' . $meteo['main']['humidity'] . '%</h3>';
                                    ?>
                                </div>
                                <div class="col-3 hover">
                                    <?php
                                    echo '<h3>Pressure    ' . $meteo['main']['pressure'] . 'Pa</h3>';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row no-gutters justify-content-around" style="margin-left:300px; margin-top:70px;">
                    <div class="col-12 col-md-7">
                        <div class="text-center">
                            <div class="tuile mapTuile">
                                <?php
                                $mapLink = 'https://maps.darksky.net/@precipitation_rate,' . $meteo['coord']['lat'] . ',' . $meteo['coord']['lon'] . ',5?embed=true&timeControl=false&fieldControl=false&defaultField=precipitation_rate';
                                echo '<iframe class="map" src="' . $mapLink . '" height="400px;" width="600px"></iframe>';
                                ?>
                                <div class="col-md-2">
                                </div>
                                <div class="w-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>

          <img src="http://street-map.net.au/images/australia_map_states.gif"  alt="Australia Map"
          height="400" width="400" usemap="#australiamap">
          <map name="australiamap">
                <area shape="poly" title= "South Australia" coords="257,334,146,252,146,187,254,187" alt="South Australia" href="https://weatherapp001.appspot.com/process.php?city=sa&date=15&month=10&year=2019">
                <area shape="poly" title= "Western Australia" coords="137,258,47,301,9,151,136,56" alt="Western Australia" href="https://weatherapp001.appspot.com/process.php?city=wa&date=15&month=10&year=2019">
                <area shape="poly" title= "Northern Territory" coords="230,184,141,185,141,8,231,10" alt="Northern Territory" href="https://weatherapp001.appspot.com/process.php?city=nt&date=15&month=10&year=2019">
                <area shape="poly" title= "Queensland" coords="256,184,256,220,370,224,361,178,278,5,260,83,229,70,228,183" alt="Queensland" href="https://weatherapp001.appspot.com/process.php?city=qld&date=15&month=10&year=2019">
                <area shape="poly" title= "New South Wales" coords="255,219,256,281,324,328,370,229" alt="New South Wales" href="https://weatherapp001.appspot.com/process.php?city=nsw&date=15&month=10&year=2019">
                <area shape="poly" title= "Victoria" coords="256,286,256,339,320,335,325,327" alt="Victoria" href="https://weatherapp001.appspot.com/process.php?city=vic&date=15&month=10&year=2019">
                <area shape="poly" title= "Tasmania" coords="280,366,288,395,310,395,311,368" alt="Tasmania" href="https://weatherapp001.appspot.com/process.php?city=tas&date=15&month=10&year=2019">
                </map>

          <form method="get"  action="process.php?city=<?php echo $_GET['city']?>+year=<?php echo $_GET['year']?>+mo=<?php echo $_GET['month']?>+date=<?php echo $_GET['date']?>">
         <br></br>

          <h5>Search for weather by entering state name</h5>
          <p></p>
          <input type="text" class="form-control" id="city" name="city" aria-describedby="city" placeholder="SA, WA, NT, QLD, NSW, VIC, TAS" required style= "width: 600px">
          <span class="validity"></span>
          <div class="fallbackDatePicker">
                <div>
                   <span>
                    <label for="date">Date:</label>
                    <select id="date" name="date">
                      <option selected>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                    </select>
                  </span>
                  <span>
                    <label for="month">Month:</label>
                    <select id="month" name="month">
                       <option selected>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                    </select>
                  </span>
                  <span>
                    <label for="year">Year:</label>
                    <select id="year" name="year">
                      <option selected>2019</option>
                      <option>2018</option>
                      <option>2017</option>
                      <option>2016</option>
                      <option>2015</option>
                      <option>2014</option>
                      <option>2013</option>
                    </select>
                  </span>
                </div>
              </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
  </body>
</html>
