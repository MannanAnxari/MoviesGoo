import json

# Load the JSON data from the file
file_path = "allDataForMovies.json"
with open(file_path, "r") as file:
    data = json.load(file)

# Filter the data based on the "genres" field
animation_movies = [movie for movie in data if movie is not None if any(genre["name"] == "Animation" for genre in movie.get("genres", []))]

# Now the variable `animation_movies` contains the filtered data with movies that have the genre "Animation"
# You can use this data for further processing or save it to a new JSON file if needed.

# For example, to save the filtered data to a new file:
output_file_path = "animation_movies.json"
with open(output_file_path, "w") as output_file:
    json.dump(animation_movies, output_file, indent=2)

print(f"Filtered data with {len(animation_movies)} movies having the 'Animation' genre has been saved to '{output_file_path}'.")
