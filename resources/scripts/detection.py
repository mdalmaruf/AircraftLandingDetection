# -*- coding: utf-8 -*-
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



c_landing = pd.read_csv(r"C:\Users\100641313\PhpstormProjects\laravel-8-boilerplate\resources\scripts\c_landing3000_script_test.csv",  encoding='utf-8-sig', sep='\s*,\s*', engine='python')
df_ld_gr = c_landing.groupby('landingid')

landing_status=[]


#single_landing=df_ld_gr.get_group(('02b3425f-3d7f-48d9-97ab-aaae212a494c'))
#status = single_landing['detection'].where(single_landing['detection'].eq(True), False).all()
#id = '02b3425f-3d7f-48d9-97ab-aaae212a494c'
#landing_id=[id]
#detection_val=[status]


single_landing=df_ld_gr.get_group(('000de98b-62bf-47e7-b19a-b63a9920dba8'))
status = single_landing['detection'].where(single_landing['detection'].eq(True), False).all()
id = '000de98b-62bf-47e7-b19a-b63a9920dba8'
landing_id=[id]
detection_val=[status]

#single_landing=df_ld_gr.get_group(('02cb4a06-1936-4292-af97-cb54b2cded57'))
#status = single_landing['detection'].where(single_landing['detection'].eq(True), False).all()
#id = '02cb4a06-1936-4292-af97-cb54b2cded57'
#landing_id.append(id)
#detection_val.append(status)

print(landing_id)
print(detection_val)



