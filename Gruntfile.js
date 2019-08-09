module.exports = function(grunt) {
    grunt.initConfig({
		sass: {
			options: {
                includePaths: ['node_modules/bootstrap-sass/assets/stylesheets']
            },
            dist: {
				options: {
					outputStyle: 'compressed'
				},
                files: [{
                    'public/assets/css/main.css': 'public/assets/scss/main.scss',  							/* 'All main SCSS' */
                    'public/assets/css/color_skins.css': 'public/assets/scss/color_skins.scss', 				/* 'All Color Option' */

                    'public/assets/css/timeline.css': 'public/assets/scss/pages/timeline.scss', 				/* 'Timeline SCSS to CSS' */
                    'public/assets/css/blog.css': 'public/assets/scss/pages/blog.scss', 						/* 'Blog page' */                    
                    'public/assets/css/inbox.css': 'public/assets/scss/pages/inbox.scss', 					/* 'Email App' */
                    'public/assets/css/rtl.css': 'public/assets/scss/pages/rtl.scss', 						/* 'RTL Support Dashboard scss' */
                    'public/assets/css/ecommerce.css': 'public/assets/scss/pages/ecommerce.scss', 			/* 'eCommerce scss' */
				}]
            }
        },
        uglify: {
          my_target: {
            files: {
                'public/assets/bundles/libscripts.bundle.js': ['public/assets/plugins/jquery/jquery-v3.2.1.min.js','public/assets/plugins/bootstrap/js/popper.min.js','public/assets/plugins/bootstrap/js/bootstrap.js'], /* main js*/              
                'public/assets/bundles/vendorscripts.bundle.js':
                ['public/assets/plugins/bootstrap-select/js/bootstrap-select.js','public/assets/plugins/jquery-slimscroll/jquery.slimscroll.js','public/assets/plugins/node-waves/waves.js','public/assets/plugins/fullscreen/screenfull.js','public/assets/plugins/jquery-sparkline/jquery.sparkline.js','public/assets/plugins/jquery-countto/jquery.countTo.js','public/assets/plugins/bootstrap-progressbar/js/bootstrap-progressbar.min.js'], /* coman js*/
                'public/assets/bundles/mainscripts.bundle.js':
                ['public/assets/js/admin.js','public/assets/js/demo.js','public/assets/js/fullscreen.js'], /*coman js*/				                
                

                'public/assets/bundles/morrisscripts.bundle.js': ['public/assets/plugins/raphael/raphael.min.js','public/assets/plugins/morrisjs/morris.js'], /* Morris Plugin Js */
                'public/assets/bundles/flotscripts.bundle.js': ['public/assets/plugins/flot-charts/jquery.flot.js','public/assets/plugins/flot-charts/jquery.flot.resize.js','public/assets/plugins/flot-charts/jquery.flot.pie.js','public/assets/plugins/flot-charts/jquery.flot.categories.js','public/assets/plugins/flot-charts/jquery.flot.time.js'], /* Flot Chart js*/ 
                'public/assets/bundles/chartscripts.bundle.js': ['public/assets/plugins/chartjs/Chart.bundle.js'], /* ChartJs js*/                
                'public/assets/bundles/sparkline.bundle.js': ['public/assets/plugins/jquery-sparkline/jquery.sparkline.js'], /* sparkline js*/               
                'public/assets/bundles/countTo.bundle.js': ['public/assets/plugins/jquery-countto/jquery.countTo.js'], /* CountTo js*/               
                'public/assets/bundles/knob.bundle.js': ['public/assets/plugins/jquery-knob/jquery.knob.min.js'], /* knob js*/
                'public/assets/bundles/c3.bundle.js':['public/assets/plugins/charts-c3/js/c3.min.js', 'public/assets/plugins/charts-c3/js/d3.v3.min.js'], /* C3 Chart js*/
                'public/assets/bundles/echarts.bundle.js': ['public/assets/plugins/echart/echarts.min.js'],

                'public/assets/bundles/jvectormap.bundle.js': ['public/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js','public/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'], /* jvectormap js*/
                'public/assets/bundles/fullcalendarscripts.bundle.js': ['public/assets/plugins/fullcalendar/lib/moment.min.js','public/assets/plugins/fullcalendar/lib/jquery-ui.min.js','public/assets/plugins/fullcalendar/fullcalendar.min.js'],   /* calender page js */
                'public/assets/bundles/datatablescripts.bundle.js': ['public/assets/plugins/jquery-datatable/jquery.dataTables.min.js','public/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.js'], /* Jquery DataTable Plugin Js  */
                'public/assets/bundles/footable.bundle.js': ['public/assets/plugins/footable-bootstrap/js/footable.js'], /* footable js*/
              }
            }
        }                
    });
    grunt.loadNpmTasks("grunt-sass");
    grunt.loadNpmTasks('grunt-contrib-uglify');
    
    grunt.registerTask("buildcss", ["sass"]);	
    grunt.registerTask("buildjs", ["uglify"]);
};