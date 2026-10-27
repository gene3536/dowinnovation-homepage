<div id="container" style="min-width: 400px; height: 500px; margin: 20px auto"></div>
<script type="text/javascript">
	$(function () {
	    var chart;
	    $(document).ready(function() {
	        chart = new Highcharts.Chart({
	            chart: {
	                renderTo: 'container',
	                type: 'column'
	            },
	            title: {
	                text: 'Yearly Average Visit'
	            },
	            subtitle: {
	                text: null
	            },
	            xAxis: [{
	            	categories: [
						<?php
							for($i = $startYear; $i <= $thisYear; $i++) {
	         	            	echo "'".$i."'";
	         	            	if($i < $thisYear) echo ",";
							}
						?>
					],
					labels: {
	                    y: 20,
	                    style: {fontSize: '12px'}
	                }
	            }],
	            yAxis: [{
	            	min: 0,
	            	title: null         
	            }],
	            tooltip: {
	                formatter: function() {
	                    return ''+
	                        this.x +': '+ this.y;
	                }
	            },
	            legend: {
	                layout: 'vertical',
	                align: 'right',
	                x: -20,
	                verticalAlign: 'top',
	                y: 40,
	                borderWidth: 0,	                
	                floating: true,
	                backgroundColor: '#FFFFFF'
	            },
	            credits: {
	                enabled: false
	            },
	            tooltip: {
	                formatter: function() {
	                    return '<b>'+ this.x +'</b><br/>'+
	                        'Site Visit: '+ Highcharts.numberFormat(this.y, 0);
	                }
	            },
	            series: [{
	                name: 'Site Visits',
	                color: '#4572A7',
	                data: [
						<?php
							for($i = $startYear; $i <= $thisYear; $i++) {
								$statCount = $statClass -> getStatCountSum($scode, 4, $i, "", "", "", "", "");	
					        	if($statCount > 0) { 
					        		echo $statCount;
					        	} else {
					        		echo "0";
				    	    	}
				        		if($i < $thisYear) echo ",";
							}
						?>
					],
		            dataLabels: {
	                    enabled: true,
	                    color: '#4572A7',
	                    x: 0,
	                    y: 10,
	                    formatter: function() {
	                        return this.y;
	                    },
	                    style: {
	                        fontSize: '12px'
	                    }
	                }				
	            }]
	        });
	    });	    
	});
</script>