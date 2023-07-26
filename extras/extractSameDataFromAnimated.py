
import json
import re

with open("data.json", "r") as data_file:
    data = json.load(data_file)[0].get('data')

with open("allDataForMovies.json", "r") as animated_file:
    animated_data = json.load(animated_file)

print(len(animated_data), len(data))
imdb_ids_in_animated = {movie["imdb_id"] for movie in animated_data}

def extractImdbId(url):
    return "tt"+re.search(r"tt(\d+)", url).group(1)
# for movie in data:
#     print(extractImdbId(movie.get("imdb")))
filtered_data = [movie for movie in data if extractImdbId(movie.get("imdb")) in imdb_ids_in_animated]

output_file_path = "filtered_data.json"
with open(output_file_path, "w") as output_file:
    json.dump(filtered_data, output_file, indent=2)

print(f"Filtered data with {len(filtered_data)} movies has been saved to '{output_file_path}'.")
