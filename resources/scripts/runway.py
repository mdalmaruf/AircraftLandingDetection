# -*- coding: utf-8 -*-
import sys
import numpy as np
import pandas as pd
import webbrowser
# !pip install gmplot
# !pip install geopandas
# import gmplot package
import gmplot
#point conversion package
from shapely.geometry import Point
from shapely.geometry.polygon import Polygon

#from geopandas import GeoDataFrame
import matplotlib.pyplot as plt

apikey = 'AIzaSyDEdhla-UhiwFlarNsjyGKTYQ8sVSV4F6k'




df_runway = np.array([[32,
                      '45.309890, -75.653972', '45.310411, -75.653369','45.311009, -75.654690', '45.310574, -75.655146', #approach
                      '45.310574, -75.655146', '45.311009, -75.654690', '45.313457, -75.659422', '45.313039, -75.659886', #touchdown
                      '45.313039, -75.659886', '45.313457, -75.659422', '45.327241, -75.685997', '45.326815, -75.686448', #landing_phase
                      '45.317146, -75.666527', '45.317938, -75.665630', '45.318257, -75.666136', '45.317685, -75.667568', #exit1_32
                      '45.320218, -75.672427', '45.321087, -75.671562', '45.321321, -75.672170', '45.320554, -75.673058', #exit2_32
                      '45.324817, -75.681292', '45.326179, -75.680739', '45.326435, -75.681335','45.325249, -75.682133',  #exit3_32_14
                      '45.326718, -75.684948', '45.327811, -75.683801', '45.328090, -75.684219', '45.327236, -75.685921'], #exit4_32_14
                      [14,
                       '45.327825, -75.686919', '45.327222, -75.687409', '45.326835, -75.686478', '45.327265, -75.686049', #approach
                       '45.327265, -75.686049', '45.326835, -75.686478', '45.324373, -75.681750', '45.324798, -75.681295', #touchdown
                       '45.324798, -75.681295', '45.324373, -75.681750', '45.310574, -75.655146', '45.311009, -75.654690', #landding_phase
                       '45.324817, -75.681292', '45.326179, -75.680739', '45.326435, -75.681335','45.325249, -75.682133', #exit1_14 #exit3_32_14
                       '45.320218, -75.672427', '45.321087, -75.671562', '45.321321, -75.672170', '45.320554, -75.673058', #exit2_14 #exit2_32
                       '45.317146, -75.666527', '45.317938, -75.665630', '45.318257, -75.666136', '45.317685, -75.667568', #exit3_14 ##exit1_32
                       '45.313876, -75.660215', '45.313500, -75.659444', '45.313479, -75.658267', '45.313723, -75.658234' #exit4_14_32

                      ],
                      [25,
                      '45.324828, -75.644922', '45.325191, -75.644143', '45.325674, -75.644546', '45.325323, -75.645344' , #approach
                      '45.324828, -75.644922', '45.325323, -75.645344', '45.323068, -75.650288', '45.322634, -75.649889', #touchdown
                      '45.322634, -75.649889', '45.323068, -75.650288', '45.313551, -75.671559', '45.313076, -75.671120', #landding_phase
                       '45.321796, -75.653186', '45.322725, -75.652475', '45.322863, -75.652837', '45.321244, -75.654460', #exit1_25 #exit1
                       '45.317481, -75.662769', '45.317858, -75.663595', '45.317595, -75.663886', '45.317278, -75.663242',  #exit2_25 #exit2
                       '45.316430, -75.665093', '45.316865, -75.666000', '45.316448, -75.666463', '45.316098, -75.665811' , #exit3_25 #exit3
                       '45.313794, -75.670945', '45.314262, -75.671202', '45.314285, -75.671642','45.313551, -75.671559' #exit4_25 #exit4

                      ],

                      [7,
                       '45.312728, -75.671931', '45.313076, -75.671120', '45.313551, -75.671559', '45.313195, -75.672285',
                       '45.313076, -75.671120', '45.315307, -75.666163', '45.315742, -75.666578', '45.313551, -75.671559',
                       '45.315307, -75.666163', '45.324842, -75.644949', '45.325265, -75.645340', '45.315742, -75.666578',
                       '45.316430, -75.665093', '45.316865, -75.666000', '45.316448, -75.666463', '45.316098, -75.665811', #exit1_07 #exit3_25
                       '45.317481, -75.662769', '45.317858, -75.663595', '45.317595, -75.663886', '45.317278, -75.663242', #exit2_07 #exit2_25
                       '45.321796, -75.653186', '45.322725, -75.652475', '45.322863, -75.652837', '45.321244, -75.654460', #exit3_07 #exit1_25
                       '45.325050, -75.645936', '45.325307, -75.645357', '45.325792, -75.646067', '45.325494, -75.646229' #exit4_07

                      ]

                     ])

df_runway = pd.DataFrame(data=df_runway,  columns=["Runway",
                                                   "approach_point1", "approach_point2", "approach_point3", "approach_point4",
                                                   "touch_down_point1", "touch_down_point2", "touch_down_point3","touch_down_point4",
                                                   "landing_phase_point1", "landing_phase_point2", "landing_phase_point3","landing_phase_point4",
                                                   "exit1_area_point1", "exit1_area_point2", "exit1_area_point3", "exit1_area_point4",
                                                   "exit2_area_point1", "exit2_area_point2", "exit2_area_point3", "exit2_area_point4",
                                                   "exit3_area_point1", "exit3_area_point2", "exit3_area_point3", "exit3_area_point4",
                                                   "exit4_area_point1", "exit4_area_point2", "exit4_area_point3", "exit4_area_point4"
                                                   ])


gmap = gmplot.GoogleMapPlotter(45.317596, -75.661722, 30, apikey=apikey)

c_landing = pd.read_csv(r"C:\Users\100641313\PhpstormProjects\laravel-8-boilerplate\resources\scripts\c_landing3000_script_test.csv",  encoding='utf-8-sig', sep='\s*,\s*', engine='python')
df_ld = c_landing.groupby('landingid')

count_ranway =1
exit_color = ['#FF7F50', '#00CED1', '#FFD700', '#8A2BE2']
for index, row in df_runway.iterrows():
#     print(index)
#     if(index ==2):
#         exit_color =
        approach = zip(*[ eval(row['approach_point1']),
                               eval(row['approach_point2']),
                                    eval(row['approach_point3']),
                                         eval(row['approach_point4'])
                                              ])
        gmap.polygon(*approach, color='#3B0B39', size=40,  edge_width=5)

        touchdown = zip(*[ eval(row['touch_down_point1']),
                               eval(row['touch_down_point2']),
                                    eval(row['touch_down_point3']),
                                         eval(row['touch_down_point4'])
                                              ])

        gmap.polygon(*touchdown, color='#CD5C5C', size=40, edge_width=8)



        landing_phase = zip(*[ eval(row['landing_phase_point1']),
                               eval(row['landing_phase_point2']),
                                    eval(row['landing_phase_point3']),
                                         eval(row['landing_phase_point4'])
                                              ])

        gmap.polygon(*landing_phase, color='#9FE2BF', size=40, edge_width=5)


        exit1 = zip(*[ eval(row['exit1_area_point1']),
                               eval(row['exit1_area_point2']),
                                    eval(row['exit1_area_point3']),
                                         eval(row['exit1_area_point4'])
                                              ])

        gmap.polygon(*exit1, color=exit_color[index], size=40, edge_width=5)


        exit2 = zip(*[ eval(row['exit2_area_point1']),
                               eval(row['exit2_area_point2']),
                                    eval(row['exit2_area_point3']),
                                         eval(row['exit2_area_point4'])
                                              ])

        gmap.polygon(*exit2, color=exit_color[index], size=40, edge_width=5)

        exit3 = zip(*[ eval(row['exit3_area_point1']),
                               eval(row['exit3_area_point2']),
                                    eval(row['exit3_area_point3']),
                                         eval(row['exit3_area_point4'])
                                              ])

        gmap.polygon(*exit3, color=exit_color[index], size=40, edge_width=5)


        exit4 = zip(*[ eval(row['exit4_area_point1']),
                               eval(row['exit4_area_point2']),
                                    eval(row['exit4_area_point3']),
                                         eval(row['exit4_area_point4'])
                                              ])

        gmap.polygon(*exit4, color=exit_color[index], size=40, edge_width=5)






gmap.draw("four_runway.html")

