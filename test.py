import pandas as pd
from sklearn.cluster import DBSCAN
from sklearn.preprocessing import StandardScaler

# read in survey data from a CSV file
#survey_data = pd.read_csv('survey_data.csv') #connect to database instead
survey_data = pd.read_excel('excel/Survey_Dummy-Data.xlsx', sheet_name='Sheet1')

print(survey_data)