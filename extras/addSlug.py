import json
import re

file_path = "data.json"
with open(file_path, "r") as file:
    
    data = json.load(file)

# check array length 
#print(len(data[0].get('data')))

for item in data[0].get("data"):
    title = item.get('title')
    year = item.get('year')
    language = item.get('language')

    if title is not None:
        
        slug = re.sub(r'[\s_:;\'\"]+', '-', f"{title} {'' if year == '0000' else year} watch online in {language}".lower())
        item['slug'] = slug
 
with open(file_path, "w") as file:
    json.dump(data, file)