<div class="header">
            
            <h1 class="page-title"> <?php echo $this->lang->line('_Redis'); ?> <?php echo $this->lang->line('_Health Monitor'); ?> <?php echo $this->lang->line('chart'); ?></h1>
</div>
        
<ul class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><?php echo $this->lang->line('home'); ?></a> <span class="divider">/</span></li>
            <li><a href="<?php echo site_url('redis/index'); ?>"><?php echo $this->lang->line('_Redis Monitor'); ?></a></li><span class="divider">/</span></li>
            <li class="active"><?php echo $this->lang->line('_Health Monitor'); ?> <?php echo $this->lang->line('chart'); ?></li>
</ul>

<div class="container-fluid">
<div class="row-fluid">

<div class="btn-toolbar">
                <div class="btn-group">
                  <a class="btn btn-default <?php if($begin_time=='30') echo 'active'; ?>" href="<?php echo site_url('redis/chart/'.$cur_server_id.'/30/min') ?>"><i class="fui-calendar-16"></i>&nbsp;30 <?php echo $this->lang->line('date_minutes'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='60') echo 'active'; ?>" href="<?php echo site_url('redis/chart/'.$cur_server_id.'/60/hour') ?>"><i class="fui-calendar-16"></i>&nbsp;1 <?php echo $this->lang->line('date_hours'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='180') echo 'active'; ?>" href="<?php echo site_url('redis/chart/'.$cur_server_id.'/180/hour') ?>"><i class="fui-calendar-16"></i>&nbsp;3 <?php echo $this->lang->line('date_hours'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='360') echo 'active'; ?>" href="<?php echo site_url('redis/chart/'.$cur_server_id.'/360/hour') ?>"><i class="fui-calendar-16"></i>&nbsp;6 <?php echo $this->lang->line('date_hours'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='720') echo 'active'; ?>" href="<?php echo site_url('redis/chart/'.$cur_server_id.'/720/hour') ?>"><i class="fui-calendar-16"></i>&nbsp;12 <?php echo $this->lang->line('date_hours'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='1440') echo 'active'; ?>" href="<?php echo site_url('redis/chart/'.$cur_server_id.'/1440/day') ?>"><i class="fui-calendar-16"></i>&nbsp;1 <?php echo $this->lang->line('date_days'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='4320') echo 'active'; ?>" href="<?php echo site_url('redis/chart/'.$cur_server_id.'/4320/day') ?>"><i class="fui-calendar-16"></i>&nbsp;3 <?php echo $this->lang->line('date_days'); ?></a>
                  <a class="btn btn-default <?php if($begin_time=='10080') echo 'active'; ?>" href="<?php echo site_url('redis/chart/'.$cur_server_id.'/10080/day') ?>"><i class="fui-calendar-16"></i>&nbsp;1 <?php echo $this->lang->line('date_weeks'); ?></a>
                </div>
</div> <!-- /toolbar -->             
<hr/>
<div id="clients" style="margin-top:10px; margin-left:0px; width:96%; height:300px;"></div>
<div id="used_memory" style="margin-top:10px; margin-left:0px; width:96%; height:300px;"></div>
<div id="keyspace" style="margin-top:10px; margin-left:0px; width:96%; height:300px;"></div>
<div id="keys" style="margin-top:10px; margin-left:0px; width:96%; height:300px;"></div>
<div id="rejected_connections" style="margin-top:10px; margin-left:0px; width:96%; height:300px;"></div>
<div id="total_commands_processed" style="margin-top:10px; margin-left:0px; width:96%; height:300px;"></div>
<div id="instantaneous_ops_per_sec" style="margin-top:10px; margin-left:0px; width:96%; height:300px;"></div>




<script src="lib/jquery-1.7.2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./lib/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="./lib/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
<link href="./lib/jqplot/jquery.jqplot.min.css"  rel="stylesheet">


<script type="text/javascript">

//=========================clients=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['connected_clients']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['blocked_clients']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];

  var plot1 = $.jqplot('clients', [data1,data2], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            label: "",
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString:"<?php echo $chart_option['formatString']; ?>",   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "<?php echo $cur_server; ?> clients <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'connected_clients'},{label: 'blocked_clients'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});



//=========================keyspace=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['keyspace_hits']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['keyspace_misses']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];

  var plot1 = $.jqplot('keyspace', [data1,data2], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            label: "",
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString:"<?php echo $chart_option['formatString']; ?>",   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "<?php echo $cur_server; ?> keyspace <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'keyspace_hits'},{label: 'keyspace_misses'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#EAA228", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});



//=========================keys=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['expired_keys']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];
  var data2=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['evicted_keys']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];

  var plot1 = $.jqplot('keys', [data1,data2], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            label: "",
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString:"<?php echo $chart_option['formatString']; ?>",   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "<?php echo $cur_server; ?> keyspace <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'expired_keys'},{label: 'evicted_keys'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});


//=========================rejected_connections=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['rejected_connections']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];

  var plot1 = $.jqplot('rejected_connections', [data1], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            label: "",
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString:"<?php echo $chart_option['formatString']; ?>",   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "<?php echo $cur_server; ?> rejected_connections <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'rejected_connections'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});



//=========================total_commands_processed=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['total_commands_processed']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];

  var plot1 = $.jqplot('total_commands_processed', [data1], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            label: "",
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString:"<?php echo $chart_option['formatString']; ?>",   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "<?php echo $cur_server; ?> total_commands_processed <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'total_commands_processed'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)  
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [ "#ff5800", "#4bb2c5", "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});


//=========================memory_usage=========================================//
$(document).ready(function(){
    var data1=[
        <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
        ["<?php echo $item['time']?>", <?php echo $item['used_memory']?> ],
        <?php }}else{ ?>
        []
        <?php } ?>
    ];

    var plot1 = $.jqplot('used_memory', [data1], {
        axes:{
            xaxis:{
                renderer:$.jqplot.DateAxisRenderer,
                label: "",
                pad:1.1,
                tickOptions: {
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示
                    // 值也分为：'outside', 'inside' 和 'cross',
                    showMark: false,     //设置是否显示刻度
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）
                    //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴
                    //在刻度线中间交叉，那么这时这个距离×2,
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值
                    formatString:"<?php echo $chart_option['formatString']; ?>",   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"
                    fontSize:'',    //刻度值的字体大小
                    fontFamily:'Tahoma', //刻度值上字体
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向
                    fontWeight:'normal', //字体的粗细
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

                }
            },
        },

        title: {
            text: "<?php echo $cur_server; ?> used_memory(MB) <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题
            show: true,//设置当前标题是否显示
            fontSize:'13px',    //刻度值的字体大小
        },
        seriesDefaults: {
            show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）
            xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.
            yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.
            label: '',      // 用于显示在分类名称框中的分类名称
            color: '',      // 分类在图标中表示（折现，柱状图等）的颜色
            lineWidth: 1.5, // 分类图（特别是折线图）宽度
            shadow: true,   // 各图在图表中是否显示阴影区域
            showLine: true,     //是否显示图表中的折线（折线图中的折线）
            showMarker: false,   // 是否强调显示图中的数据节点
            fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend
            rendererOptions: {
                smooth: true,
            },

        },
        series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性
            //eg.设置各个分类在分类名称框中的分类名称
            {label: 'used_memory'}
            //配置参数设置同seriesDefaults
        ],
        legend: {
            show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置）
            label:'',
            location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.
            xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）
            yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)
            background:'',        //分类名称框距图表区域背景色
            textColor:''          //分类名称框距图表区域内字体颜色
        },
        seriesColors: [ "#ff5800", "#4bb2c5", "#839557", "#958c12",
            "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色
        highlighter: {
            show: true,
            showLabel: true,
            tooltipAxes: '',
            sizeAdjust: 1.5 ,
            tooltipLocation : 'ne',
        },
        cursor:{
            show: true,
            zoom: true
        },

    });
});





//=========================instantaneous_ops_per_sec=========================================//
$(document).ready(function(){  
  var data1=[
    <?php if(!empty($chart_reslut)) { foreach($chart_reslut as $item){ ?>
    ["<?php echo $item['time']?>", <?php echo $item['instantaneous_ops_per_sec']?> ],
    <?php }}else{ ?>
    []    
    <?php } ?>
  ];

  var plot1 = $.jqplot('instantaneous_ops_per_sec', [data1], {
    axes:{
        xaxis:{
            renderer:$.jqplot.DateAxisRenderer,
            label: "",
            pad:1.1,
            tickOptions: {  
                    mark: 'cross',    // 设置横（纵）坐标刻度在坐标轴上显示方式，分为坐标轴内，外，穿过坐标轴显示  
                                // 值也分为：'outside', 'inside' 和 'cross',  
                    showMark: false,     //设置是否显示刻度  
                    showGridLine: true, // 是否在图表区域显示刻度值方向的网格线  
                    markSize:0,        // 每个刻度线顶点距刻度线在坐标轴上点距离（像素为单位）  
                                //如果mark值为 'cross', 那么每个刻度线都有上顶点和下顶点，刻度线与坐标轴  
                                //在刻度线中间交叉，那么这时这个距离×2,  
                    show: true,         // 是否显示刻度线，与刻度线同方向的网格线，以及坐标轴上的刻度值  
                    showLabel: true,    // 是否显示刻度线以及坐标轴上的刻度值  
                    formatString:"<?php echo $chart_option['formatString']; ?>",   // 梃置坐标轴上刻度值显示格式，eg:'%b %#d, %Y'表示格式"月 日，年"，"AUG 30,2008"  
                    fontSize:'',    //刻度值的字体大小  
                    fontFamily:'Tahoma', //刻度值上字体  
                    angle:40,           //刻度值与坐标轴夹角，角度为坐标轴正向顺时针方向  
                    fontWeight:'normal', //字体的粗细  
                    fontStretch:0,//刻度值在所在方向（坐标轴外）上的伸展(拉伸)度,

            }
        },  
    },
    
    title: {  
        text: "<?php echo $cur_server; ?> instantaneous_ops_per_sec <?php echo $this->lang->line('chart'); ?>",   // 设置当前图的标题  
        show: true,//设置当前标题是否显示 
        fontSize:'13px',    //刻度值的字体大小  
    },  
    seriesDefaults: {
              show: true,     // 设置是否渲染整个图表区域（即显示图表中内容）  
              xaxis: 'xaxis', // either 'xaxis' or 'x2axis'.  
              yaxis: 'yaxis', // either 'yaxis' or 'y2axis'.  
              label: '',      // 用于显示在分类名称框中的分类名称  
              color: '',      // 分类在图标中表示（折现，柱状图等）的颜色  
              lineWidth: 1.5, // 分类图（特别是折线图）宽度  
              shadow: true,   // 各图在图表中是否显示阴影区域   
              showLine: true,     //是否显示图表中的折线（折线图中的折线）  
              showMarker: false,   // 是否强调显示图中的数据节点  
              fill: false,        // 是否填充图表中折线下面的区域（填充颜色同折线颜色）以及legend 
              rendererOptions: {
                 smooth: true,
              },
              
    },
    series:[//如果有多个分类需要显示，这在此处设置各个分类的相关配置属性  
           //eg.设置各个分类在分类名称框中的分类名称  
            {label: 'instantaneous_ops_per_sec'}
           //配置参数设置同seriesDefaults  
    ],  
    legend: {  
        show: true, //设置是否出现分类名称框（即所有分类的名称出现在图的某个位置） 
        label:'', 
        location: 'ne',     // 分类名称框出现位置, nw, n, ne, e, se, s, sw, w.  
        xoffset: 2,        // 分类名称框距图表区域上边框的距离（单位px）  
        yoffset: 2,        // 分类名称框距图表区域左边框的距离(单位px)
        background:'',        //分类名称框距图表区域背景色  
        textColor:''          //分类名称框距图表区域内字体颜色  
    },    
    seriesColors: [  "#839557", "#958c12",   
        "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],  // 默认显示的分类颜色 
    highlighter: {
            show: true, 
            showLabel: true, 
            tooltipAxes: '',
            sizeAdjust: 1.5 , 
            tooltipLocation : 'ne',
    },
    cursor:{
            show: true, 
            zoom: true
    },
      
  });
});






</script>