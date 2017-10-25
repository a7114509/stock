<!DOCTYPE html>
<style>
    a:link { text-decoration: none;}
    a:hover{color:#000000}
     table {
         border-collapse: collapse;
     }
    table, td, th {
        border: 2px solid black;
    }
    .center{text-align:center;}
    .left{text-align:left;}

</style>
<head>
    <meta charset="utf-8">
</head>
<body>


<script language="JavaScript">


    function Cl()
    {
        document.getElementById("whole").style.visibility="hidden";
        document.getElementById("news").style.visibility="hidden";
        myform.symbol.value="";
        var formId = myform.symbol.value;

    }
    function sub() {
        if (myform.symbol.value.length==0){
            alert("Please enter a symbol");
        };
    }


</script>

<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>


<div style="margin-left: auto; margin-right: auto;background: #eeeeee;width: 500px;height:240px;text-align: center;border-style: solid;
    border-color: #D5D5D5;">
    <p class="center" style="font-style:italic;font-size:30px;"}>Stock Search</p>
    <div style="width:400px;height:1px;margin:0px auto;padding:0px;background-color:#D5D5D5;overflow:hidden;"></div></br>
    <form id="myform" name="myform" action="" method="post">
    Enter Stock Ticker Symbol*: <input type="text" name="symbol" ></br>
    <input type="submit" onclick="sub()" value="search">
    <input align="center" type="button" onclick="Cl()" value="clear"></br>
</form>
    <p style="text-align: left;font-style:italic;">*- Mandatory fields.</p>
</div>

<div id="Demo"></div>

<div id="whole">

<?php
try{
date_default_timezone_set('America/New_York');
    if (!empty($_POST["symbol"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $symbol = $_POST["symbol"];
        $URL = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY_ADJUSTED&symbol=" . $symbol . "&outputsize=full&apikey=ZS2XOLDZ98RBV0LG";
        //$URL.=$symbol;
        $error = "API is not available this time";
        if(!$json = file_get_contents($URL)){
            throw new Exception($error);
        };


        //echo "document.getElementsById('whole').style.visibility='hidden'";
        echo "<script>myform.symbol.value='$symbol';</script>";

        $quote = json_decode($json);
        $quote1 = json_decode($json, true);
        //var_dump($quote);
        $error = "Error:NO recored has been found, please enter a valid symbol";

        if (key($quote) != "Meta Data") {
            throw new Exception($error);
        };


        $data1 = $quote->{'Meta Data'}->{'3. Last Refreshed'};


        $date2 = date("m/d/Y", strtotime("$data1"));
        $data1 = date("Y-m-d", strtotime("$data1"));

        $keys = array_keys($quote1['Time Series (Daily)']);
        $test1 = $quote->{'Time Series (Daily)'};
        $test2 = $quote->{'Time Series (Daily)'}->{$keys[0]};
        $currentS = current($test1);
        $nextS = next($test1);
        $close1 = $currentS->{'4. close'};
        $open1 = $currentS->{'1. open'};
        $high1 = $currentS->{'2. high'};
        $low1 = $currentS->{'3. low'};
        $pclose1 = $nextS->{'4. close'};
        $volume1 = $currentS->{'6. volume'};
        $change1 = number_format(($close1 - $pclose1), 2);
        $changeper1 = number_format(($change1 / $pclose1) * 100, 2);
        //print_r($test1);
        //$test1=$quote(0);
        //echo $test1;
        //var_dump($test2);

        echo "<table style='border-color: #D5D5D5;' align='center' width='1000px'><tr>";
        echo "<td style='background: #ebebeb'>Stock Ticker Symbol</td>";
        echo "<td class='center'>$symbol</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Close</td>";
        echo "<td class='center'>$close1</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Open</td>";
        echo "<td class='center'>$open1</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Previous Close</td>";
        echo "<td class='center'>$pclose1</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Change</td>";
        echo "<td class='center'>$change1";
        if ($change1 > 0) {
            echo "<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png' alt='up' width='10' high='10'>";
        } else {
            echo "<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png' alt='up' width='10' high='10'>";
        }
        echo "</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Change Percent</td>";
        echo "<td class='center'>$changeper1%";
        if ($change1 > 0) {
            echo "<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png' alt='up' width='10' high='10'>";
        } else {
            echo "<img src='http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png' alt='up' width='10' high='10'>";
        }
        echo "</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Day's Range</td>";
        echo "<td class='center'>$low1-$high1</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Volume</td>";
        echo "<td class='center'>$volume1</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Timestamp</td>";
        echo "<td class='center'>$data1</td>";
        echo "</tr><tr>";
        echo "<td style='background: #ebebeb'>Indicators</td>";
        echo "<td class='center'><a onclick='Price()' href='#news'>Price<a>&nbsp;&nbsp;<a onclick='SMAcl()'href='#news'>SMA<a>&nbsp;&nbsp;<a onclick='EMAcl()' href='#news'>EMA<a>&nbsp;&nbsp;<a onclick='STOcl()' href='#news'>STOCH<a>&nbsp;&nbsp;<a onclick='RSIcl()' href='#news'>RSI<a>&nbsp;&nbsp;<a onclick='ADXcl()' href='#news'>ADX<a>&nbsp;&nbsp;<a onclick='CCIcl()' href='#news'>CCI<a>&nbsp;&nbsp;<a onclick='BBAcl()' href='#news'>BBANDS<a>&nbsp;&nbsp;<a onclick='MACcl() 'href='#news'>MACD<a></td>";
        echo "</tr></table></br>";
        // echo $_POST["symbol"];
        echo "<div id='container' style='margin-left: auto; margin-right: auto; border-style: solid;border-color: #D5D5D5; width: 1000px; height:400px'></div>"; //chart
        $datetime = 0;
        for ($i = 0; $i < 143; $i++) {
            $volume = $quote->{'Time Series (Daily)'}->{$keys[$i]}->{'6. volume'};
            $volume = $volume / 1000000;
            $price = $quote->{'Time Series (Daily)'}->{$keys[$i]}->{'4. close'};
            $formatdate = date("Y,m,d", strtotime("$keys[$i] -1 month"));
            $formatdate = "Date.UTC(" . $formatdate . ")";
            $data[] = "[$formatdate, $volume]";
            $data2[] = "[$formatdate, $price]";
        }
        $dataString = join($data, ',');
        $dataString2 = join($data2, ',');
        //print_r($dataString);
        echo "<div id='shownews' align='center'>click to show stock news<br><img onclick='shownews()' src='http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png' alt='logo' width='40' high='14'></div>";

        $xml = simplexml_load_file("https://seekingalpha.com/api/sa/combined/$symbol.xml");
        echo "<div id='news' align='center' style='visibility: hidden'>";
        echo "<table style='background: #f8f8f8; width:1000px'>";

        $j = 0;
        foreach ($xml->channel->item as $item) {
            $news1 = $item->link;
            $news = "news?";
            if (!strstr($news1, $news)) {
                echo "<tr><td><a href='" . $item->link . "'>"; //$item->title;
                echo $item->title . "</a>";
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Publicated Time:" . $item->pubDate . "</td></tr>";
                $j++;
            }
            if ($j > 4) {
                break;
            };

        }
        echo "</table>";
        echo "<div>";
    }
    }
    }
catch(Exception $e){
    echo  "<table align='center' width='1000px'><tr><td style='background: #ebebeb'>error</td>";
        echo "<td align='center'>",$e->getMessage(),"</td></tr><table>";


}
    ?>

</div>




<script>
    function hidenews() {
        document.getElementById("news").style.visibility = "hidden";
        document.getElementById("hidenews").innerHTML="<div id='shownews' align='center'>click to show stock news<br><img onclick='shownews()' src='http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png' alt='logo' width='40' high='14'></div>";
    }
    function shownews() {
        document.getElementById("news").style.visibility = "visible";
        document.getElementById("shownews").innerHTML="<div id='hidenews' align='center'>click to hide stock news<br><img onclick='hidenews()' src='http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Up.png' alt='logo' width='40' high='14'></div>";
    }

    chart1 = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
        },
        title: {
            text: "Stock Price(<?php echo $date2 ?>)"
        },
        subtitle: {
            useHTML:true,
            text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
        },
        xAxis: {
            type: 'datetime',
            //tickInterval: 7 * 24 * 3600 * 1000,
            dateTimeLabelFormats:
                {
                    week: '%m/%d',
                },
        },
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'price',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'volume',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value}M',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        plotOptions: {
            series: {
                gapSize: 0,
            },

            column: {
                borderWidth: 0,
                color: '#FFFF78',
                pointWidth: 2,
                pointPadding: 0.8,

                //pointPadding:0.1,
            }
        },
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [

            {
                type: 'area',
                name: 'Stock Price',
                data: [<?php echo $dataString2 ?>],
            },
            {
                //data: [[2017,10,16, 11096744],[2017,10,15, 15250772]]
                type: 'column',
                name: 'Volume',
                data: [<?php echo $dataString ?>],
                yAxis: 1,
            },
        ]
    });

    var min = chart1.yAxis[1].dataMin;
    var min2 = chart1.yAxis[0].dataMin;
    var max = 4 * chart1.yAxis[1].dataMax;
    var max2 = chart1.yAxis[0].dataMax;
    chart1.yAxis[1].update({
        max: max,
    });
    chart1.yAxis[0].update({
        min: min2,
        softmax: max2,
        tickInterval: 5
    });


    function MACcl(){
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        };

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                //alert(URLSMA);
                try {
                    jsonDoc = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    alert('can not return json doc');
                };

                dateEMA = Object.keys(jsonDoc["Technical Analysis: MACD"]);
                //plane=jsonDoc["Technical Analysis: SMA"][dateSMA[1]].SMA;

                d1 = dateEMA[0].replace(/\-/g, ",");
                date1 = new Date(Date.parse(d1));
                var SMAdata = new Array();
                var SMAdata1 = new Array();
                var SMAdata2 = new Array();
                for (var i = 0; i < 143; i++) {
                    d1 = dateEMA[i].replace(/\-/g, ",");
                    date1 = new Date(Date.parse(d1));
                    predata = jsonDoc["Technical Analysis: MACD"][dateEMA[i]].MACD;
                    predata1 = jsonDoc["Technical Analysis: MACD"][dateEMA[i]].MACD_Hist;
                    predata2 = jsonDoc["Technical Analysis: MACD"][dateEMA[i]].MACD_Signal;
                    SMAdata[i] = "[" + date1.getTime() + "," + predata + "]";
                    SMAdata1[i] = "[" + date1.getTime() + "," + predata1 + "]";
                    SMAdata2[i] = "[" + date1.getTime() + "," + predata2 + "]";

                };
                var energy = "["+SMAdata.join()+"]";
                var energy1 = "["+SMAdata1.join()+"]";
                var energy2 = "["+SMAdata2.join()+"]";
                var energy = JSON.parse(energy);
                var energy1 = JSON.parse(energy1);
                var energy2 = JSON.parse(energy2);
                //document.getElementById("Demo").innerHTML = energy;

                var chart1 = new Highcharts.Chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Moving Average Convergence/Divergence (MACD)'
                    },
                    subtitle: {
                        useHTML:true,
                        text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 7 * 24 * 3600 * 1000,
                        dateTimeLabelFormats:
                            {
                                week: '%m/%d',
                            },
                    },
                    yAxis: {
                        title: {
                            text: 'MACD'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'MACD',
                        data: energy,
                    },
                        {
                            name:'MACD_Hist',
                            data:energy1,
                        },
                        {
                            name:'MACD_Signal',
                            data:energy2,
                        }
                    ]
                });
                var min = chart1.yAxis[1].dataMin;
                var min2 = chart1.yAxis[0].dataMin;
                var max = 4 * chart1.yAxis[1].dataMax;
                var max2 = chart1.yAxis[0].dataMax;
                chart1.yAxis[1].update({
                    max: max,
                });
                chart1.yAxis[0].update({
                    min: min2,
                    softmax: max2,
                    tickInterval: 5
                });



            };
        };
        symb= "<?php echo $symbol ?>"
        URLSMA='https://www.alphavantage.co/query?function=MACD&symbol='+symb+'&interval=daily&series_type=close&apikey=ZS2XOLDZ98RBV0LG';
        xmlhttp.open("GET",URLSMA,true);
        xmlhttp.send();
        //alert(URLSMA);

    }


    function BBAcl(){
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        };

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                //alert(URLSMA);
                try {
                    jsonDoc = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    alert('can not return json doc');
                };

                dateEMA = Object.keys(jsonDoc["Technical Analysis: BBANDS"]);
                //plane=jsonDoc["Technical Analysis: SMA"][dateSMA[1]].SMA;

                d1 = dateEMA[0].replace(/\-/g, ",");
                date1 = new Date(Date.parse(d1));
                var SMAdata = new Array();
                var SMAdata1 = new Array();
                var SMAdata2 = new Array();
                for (var i = 0; i < 143; i++) {
                    d1 = dateEMA[i].replace(/\-/g, ",");
                    date1 = new Date(Date.parse(d1));
                    predata = jsonDoc["Technical Analysis: BBANDS"][dateEMA[i]]["Real Middle Band"];
                    predata1 = jsonDoc["Technical Analysis: BBANDS"][dateEMA[i]]["Real Lower Band"];
                    predata2 = jsonDoc["Technical Analysis: BBANDS"][dateEMA[i]]["Real Upper Band"];
                    SMAdata[i] = "[" + date1.getTime() + "," + predata + "]";
                    SMAdata1[i] = "[" + date1.getTime() + "," + predata1 + "]";
                    SMAdata2[i] = "[" + date1.getTime() + "," + predata2 + "]";

                };
                var energy = "["+SMAdata.join()+"]";
                var energy1 = "["+SMAdata1.join()+"]";
                var energy2 = "["+SMAdata2.join()+"]";
                var energy = JSON.parse(energy);
                var energy1 = JSON.parse(energy1);
                var energy2 = JSON.parse(energy2);
                //document.getElementById("Demo").innerHTML = energy;

                var chart1 = new Highcharts.Chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Bollinger Bands (BBANDS)'
                    },
                    subtitle: {
                        useHTML:true,
                        text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 7 * 24 * 3600 * 1000,
                        dateTimeLabelFormats:
                            {
                                week: '%m/%d',
                            },
                    },
                    yAxis: {
                        title: {
                            text: 'BBANDS'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'Real Middle Band',
                        data: energy,
                    },
                        {
                            name:'Real Lower Band',
                            data:energy1,
                        },
                        {
                            name:'Real Upper Band',
                            data:energy2,
                        }
                    ]
                });
                var min = chart1.yAxis[1].dataMin;
                var min2 = chart1.yAxis[0].dataMin;
                var max = 4 * chart1.yAxis[1].dataMax;
                var max2 = chart1.yAxis[0].dataMax;
                chart1.yAxis[1].update({
                    max: max,
                });
                chart1.yAxis[0].update({
                    min: min2,
                    softmax: max2,
                    tickInterval: 5
                });



            };
        };
        symb= "<?php echo $symbol ?>"
        URLSMA='https://www.alphavantage.co/query?function=BBANDS&symbol='+symb+'&interval=daily&time_period=5&series_type=close&nbdevup=3&nbdevdn=3&apikey=ZS2XOLDZ98RBV0LG';
        xmlhttp.open("GET",URLSMA,true);
        xmlhttp.send();
        //alert(URLSMA);

    }


    function STOcl(){
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        };

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                //alert(URLSMA);
                try {
                    jsonDoc = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    alert('can not return json doc');
                };

                dateEMA = Object.keys(jsonDoc["Technical Analysis: STOCH"]);
                //plane=jsonDoc["Technical Analysis: SMA"][dateSMA[1]].SMA;

                d1 = dateEMA[0].replace(/\-/g, ",");
                date1 = new Date(Date.parse(d1));
                var SMAdata = new Array();
                var SMAdata1 = new Array();
                for (var i = 0; i < 143; i++) {
                    d1 = dateEMA[i].replace(/\-/g, ",");
                    date1 = new Date(Date.parse(d1));
                    predata = jsonDoc["Technical Analysis: STOCH"][dateEMA[i]].SlowK;
                    predata1 = jsonDoc["Technical Analysis: STOCH"][dateEMA[i]].SlowD;
                    SMAdata[i] = "[" + date1.getTime() + "," + predata + "]";
                    SMAdata1[i] = "[" + date1.getTime() + "," + predata1 + "]";

                };
                var energy = "["+SMAdata.join()+"]";
                var energy1 = "["+SMAdata1.join()+"]";
                var energy = JSON.parse(energy);
                var energy1 = JSON.parse(energy1);
                //document.getElementById("Demo").innerHTML = energy;

                var chart1 = new Highcharts.Chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Stochastic oscillator (STOCH)'
                    },
                    subtitle: {
                        useHTML:true,
                        text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 7 * 24 * 3600 * 1000,
                        dateTimeLabelFormats:
                            {
                                week: '%m/%d',
                            },
                    },
                    yAxis: {
                        title: {
                            text: 'STOCH'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'SlowK',
                        data: energy,
                    },
                        {
                            name:'SlowD',
                            data:energy1,
                        },
                    ]
                });
                var min = chart1.yAxis[1].dataMin;
                var min2 = chart1.yAxis[0].dataMin;
                var max = 4 * chart1.yAxis[1].dataMax;
                var max2 = chart1.yAxis[0].dataMax;
                chart1.yAxis[1].update({
                    max: max,
                });
                chart1.yAxis[0].update({
                    min: min2,
                    softmax: max2,
                    tickInterval: 5
                });



            };
        };
        symb= "<?php echo $symbol ?>"
        URLSMA='https://www.alphavantage.co/query?function=STOCH&symbol='+symb+'&interval=daily&slowkmatype=1&slowdmatype=1&apikey=ZS2XOLDZ98RBV0LG';
        xmlhttp.open("GET",URLSMA,true);
        xmlhttp.send();
        //alert(URLSMA);

    }


    function RSIcl(){
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        };

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                //alert(URLSMA);
                try {
                    jsonDoc = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    alert('can not return json doc');
                };

                dateEMA = Object.keys(jsonDoc["Technical Analysis: RSI"]);
                //plane=jsonDoc["Technical Analysis: SMA"][dateSMA[1]].SMA;

                d1 = dateEMA[0].replace(/\-/g, ",");
                date1 = new Date(Date.parse(d1));
                var SMAdata = new Array();
                for (var i = 0; i < 143; i++) {
                    d1 = dateEMA[i].replace(/\-/g, ",");
                    date1 = new Date(Date.parse(d1));
                    predata = jsonDoc["Technical Analysis: RSI"][dateEMA[i]].RSI;
                    SMAdata[i] = "[" + date1.getTime() + "," + predata + "]";

                };
                var energy = "["+SMAdata.join()+"]";
                var energy = JSON.parse(energy);
                //document.getElementById("Demo").innerHTML = energy;

                var chart1 = new Highcharts.Chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Relative Strength Index (RSI)'
                    },
                    subtitle: {
                        useHTML:true,
                        text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 7 * 24 * 3600 * 1000,
                        dateTimeLabelFormats:
                            {
                                week: '%m/%d',
                            },
                    },
                    yAxis: {
                        title: {
                            text: 'RSI'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'RSI',
                        data: energy,
                    },]
                });
                var min = chart1.yAxis[1].dataMin;
                var min2 = chart1.yAxis[0].dataMin;
                var max = 4 * chart1.yAxis[1].dataMax;
                var max2 = chart1.yAxis[0].dataMax;
                chart1.yAxis[1].update({
                    max: max,
                });
                chart1.yAxis[0].update({
                    min: min2,
                    softmax: max2,
                    tickInterval: 5
                });



            };
        };
        symb= "<?php echo $symbol ?>"
        URLSMA='https://www.alphavantage.co/query?function=RSI&symbol='+symb+'&interval=daily&time_period=10&series_type=close&apikey=ZS2XOLDZ98RBV0LG';
        xmlhttp.open("GET",URLSMA,true);
        xmlhttp.send();
        //alert(URLSMA);

    }


    function ADXcl(){
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        };

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                //alert(URLSMA);
                try {
                    jsonDoc = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    alert('can not return json doc');
                };

                dateEMA = Object.keys(jsonDoc["Technical Analysis: ADX"]);
                //plane=jsonDoc["Technical Analysis: SMA"][dateSMA[1]].SMA;

                d1 = dateEMA[0].replace(/\-/g, ",");
                date1 = new Date(Date.parse(d1));
                var SMAdata = new Array();
                for (var i = 0; i < 143; i++) {
                    d1 = dateEMA[i].replace(/\-/g, ",");
                    date1 = new Date(Date.parse(d1));
                    predata = jsonDoc["Technical Analysis: ADX"][dateEMA[i]].ADX;
                    SMAdata[i] = "[" + date1.getTime() + "," + predata + "]";

                };
                var energy = "["+SMAdata.join()+"]";
                var energy = JSON.parse(energy);
                //document.getElementById("Demo").innerHTML = energy;

                var chart1 = new Highcharts.Chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Average directional movement index (ADX)'
                    },
                    subtitle: {
                        useHTML:true,
                        text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 7 * 24 * 3600 * 1000,
                        dateTimeLabelFormats:
                            {
                                week: '%m/%d',
                            },
                    },
                    yAxis: {
                        title: {
                            text: 'ADX'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'ADX',
                        data: energy,
                    },]
                });
                var min = chart1.yAxis[1].dataMin;
                var min2 = chart1.yAxis[0].dataMin;
                var max = 4 * chart1.yAxis[1].dataMax;
                var max2 = chart1.yAxis[0].dataMax;
                chart1.yAxis[1].update({
                    max: max,
                });
                chart1.yAxis[0].update({
                    min: min2,
                    softmax: max2,
                    tickInterval: 5
                });



            };
        };
        symb= "<?php echo $symbol ?>"
        URLSMA='https://www.alphavantage.co/query?function=ADX&symbol='+symb+'&interval=daily&time_period=10&series_type=close&apikey=ZS2XOLDZ98RBV0LG';
        xmlhttp.open("GET",URLSMA,true);
        xmlhttp.send();
        //alert(URLSMA);

    }


    function CCIcl(){
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        };

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                //alert(URLSMA);
                try {
                    jsonDoc = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    alert('can not return json doc');
                };

                dateEMA = Object.keys(jsonDoc["Technical Analysis: CCI"]);
                //plane=jsonDoc["Technical Analysis: SMA"][dateSMA[1]].SMA;

                d1 = dateEMA[0].replace(/\-/g, ",");
                date1 = new Date(Date.parse(d1));
                var SMAdata = new Array();
                for (var i = 0; i < 143; i++) {
                    d1 = dateEMA[i].replace(/\-/g, ",");
                    date1 = new Date(Date.parse(d1));
                    predata = jsonDoc["Technical Analysis: CCI"][dateEMA[i]].CCI;
                    SMAdata[i] = "[" + date1.getTime() + "," + predata + "]";

                };
                var energy = "["+SMAdata.join()+"]";
                var energy = JSON.parse(energy);
                //document.getElementById("Demo").innerHTML = energy;

                var chart1 = new Highcharts.Chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Commodity channel index (CCI)'
                    },
                    subtitle: {
                        useHTML:true,
                        text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 7 * 24 * 3600 * 1000,
                        dateTimeLabelFormats:
                            {
                                week: '%m/%d',
                            },
                    },
                    yAxis: {
                        title: {
                            text: 'CCI'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'CCI',
                        data: energy,
                    },]
                });
                var min = chart1.yAxis[1].dataMin;
                var min2 = chart1.yAxis[0].dataMin;
                var max = 4 * chart1.yAxis[1].dataMax;
                var max2 = chart1.yAxis[0].dataMax;
                chart1.yAxis[1].update({
                    max: max,
                });
                chart1.yAxis[0].update({
                    min: min2,
                    softmax: max2,
                    tickInterval: 5
                });



            };
        };
        symb= "<?php echo $symbol ?>"
        URLSMA='https://www.alphavantage.co/query?function=CCI&symbol='+symb+'&interval=daily&time_period=10&series_type=close&apikey=ZS2XOLDZ98RBV0LG';
        xmlhttp.open("GET",URLSMA,true);
        xmlhttp.send();
        //alert(URLSMA);

    }



    function EMAcl(){
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        };

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                //alert(URLSMA);
                try {
                    jsonDoc = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    alert('can not return json doc');
                };

                dateEMA = Object.keys(jsonDoc["Technical Analysis: EMA"]);
                //plane=jsonDoc["Technical Analysis: SMA"][dateSMA[1]].SMA;

                d1 = dateEMA[0].replace(/\-/g, ",");
                date1 = new Date(Date.parse(d1));
                var SMAdata = new Array();
                for (var i = 0; i < 143; i++) {
                    d1 = dateEMA[i].replace(/\-/g, ",");
                    date1 = new Date(Date.parse(d1));
                    predata = jsonDoc["Technical Analysis: EMA"][dateEMA[i]].EMA;
                    SMAdata[i] = "[" + date1.getTime() + "," + predata + "]";

                };
                var energy = "["+SMAdata.join()+"]";
                var energy = JSON.parse(energy);
                //document.getElementById("Demo").innerHTML = energy;

                var chart1 = new Highcharts.Chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Exponential moving average (EMA)'
                    },
                    subtitle: {
                        useHTML:true,
                        text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 7 * 24 * 3600 * 1000,
                        dateTimeLabelFormats:
                            {
                                week: '%m/%d',
                            },
                    },
                    yAxis: {
                        title: {
                            text: 'EMA'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'EMA',
                        data: energy,
                    },]
                });
                var min = chart1.yAxis[1].dataMin;
                var min2 = chart1.yAxis[0].dataMin;
                var max = 4 * chart1.yAxis[1].dataMax;
                var max2 = chart1.yAxis[0].dataMax;
                chart1.yAxis[1].update({
                    max: max,
                });
                chart1.yAxis[0].update({
                    min: min2,
                    softmax: max2,
                    tickInterval: 5
                });



            };
        };
        symb= "<?php echo $symbol ?>"
        URLSMA='https://www.alphavantage.co/query?function=EMA&symbol='+symb+'&interval=daily&time_period=10&series_type=close&apikey=ZS2XOLDZ98RBV0LG';
        xmlhttp.open("GET",URLSMA,true);
        xmlhttp.send();
        //alert(URLSMA);

    }


    function Price() {
        chart1 = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
            },
            title: {
                text: "Stock Price(<?php echo $date2 ?>)"
            },
            subtitle: {
                useHTML:true,
                text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
            },
            xAxis: {
                type: 'datetime',
                tickInterval: 7 * 24 * 3600 * 1000,
                dateTimeLabelFormats:
                    {
                        week: '%m/%d',
                    },
            },
            yAxis: [{ // Primary yAxis
                labels: {
                    format: '{value}',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                },
                title: {
                    text: 'price',
                    style: {
                        color: Highcharts.getOptions().colors[1]
                    }
                }
            }, { // Secondary yAxis
                title: {
                    text: 'volume',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}M',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            }],
            plotOptions: {
                column: {
                    borderWidth: 0,
                    color: '#FFFF78',
                    pointWidth: 2,
                    pointPadding: 0.8,
                    //pointPadding:0.1,
                }
            },
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [

                {
                    type: 'area',
                    name: 'Stock Price',
                    data: [<?php echo $dataString2 ?>],
                },
                {
                    //data: [[2017,10,16, 11096744],[2017,10,15, 15250772]]
                    type: 'column',
                    name: 'Volume',
                    data: [<?php echo $dataString ?>],
                    yAxis: 1,
                },
            ]
        });
        var min = chart1.yAxis[1].dataMin;
        var min2 = chart1.yAxis[0].dataMin;
        var max = 4 * chart1.yAxis[1].dataMax;
        var max2 = chart1.yAxis[0].dataMax;
        chart1.yAxis[1].update({
            max: max,
        });
        chart1.yAxis[0].update({
            min: min2,
            softmax: max2,
            tickInterval: 5
        });


    };


    function SMAcl() {
        var xmlhttp;
        if (window.XMLHttpRequest)
        {
            xmlhttp=new XMLHttpRequest();
        };
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                try {
                    jsonDoc = JSON.parse(xmlhttp.responseText);
                } catch (err) {
                    alert('can not return json doc');
                };

                dateSMA = Object.keys(jsonDoc["Technical Analysis: SMA"]);
                //plane=jsonDoc["Technical Analysis: SMA"][dateSMA[1]].SMA;

                d1 = dateSMA[0].replace(/\-/g, ",");
                date1 = new Date(Date.parse(d1));
                var SMAdata = new Array();
                for (var i = 0; i < 143; i++) {
                    d1 = dateSMA[i].replace(/\-/g, ",");
                    date1 = new Date(Date.parse(d1));
                    predata = jsonDoc["Technical Analysis: SMA"][dateSMA[i]].SMA;
                    SMAdata[i] = "[" + date1.getTime() + "," + predata + "]";

                };
                var energy = "["+SMAdata.join()+"]";
                var energy = JSON.parse(energy);
                //document.getElementById("Demo").innerHTML = energy;

                var chart1 = new Highcharts.Chart('container', {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: 'Simple Moving Average (SMA)'
                    },
                    subtitle: {
                        useHTML:true,
                        text: "<a href='https://www.alphavantage.co/' target='_blank'>Source: Alpha Vantage</a>"
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 7 * 24 * 3600 * 1000,
                        dateTimeLabelFormats:
                            {
                                week: '%m/%d',
                            },
                    },
                    yAxis: {
                        title: {
                            text: 'SMA'
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [{
                        name: 'SMA',
                        data: energy,
                    },]
                });
                var min = chart1.yAxis[1].dataMin;
                var min2 = chart1.yAxis[0].dataMin;
                var max = 4 * chart1.yAxis[1].dataMax;
                var max2 = chart1.yAxis[0].dataMax;
                chart1.yAxis[1].update({
                    max: max,
                });
                chart1.yAxis[0].update({
                    min: min2,
                    softmax: max2,
                    tickInterval: 5
                });



            };
        };
        symb= "<?php echo $symbol ?>"
        URLSMA='https://www.alphavantage.co/query?function=SMA&symbol='+symb+'&interval=daily&time_period=10&series_type=close&apikey=ZS2XOLDZ98RBV0LG';
        xmlhttp.open("GET",URLSMA,true);
        xmlhttp.send();
        //alert(URLSMA);

    };
</script>


</body>
</html>
