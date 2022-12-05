/* fetch_random
 * Input: N/A
 * Purpose: Using a fetch request to attain a random recipe from the Spoonacular
 *          API
 * Output: N/A
 */
function fetch_random(){
    res = fetch("https://api.spoonacular.com/recipes/random?number=1&apiKey=bd18dc08d7954c4cae19b14f4f47eda8")
    .then (res => res.text())
    .then (data => {
        // Parsing Data
        result = JSON.parse(data);
        content = result.recipes[0]

        // Fetching Title
        $('#recipe_title').text(content.title);

        // Fetching Summary
        // Segments the Summary String For More Digestable Output
        summary = segment(content.summary, '.', 4)
        $('#recipe_summary').html(summary);

        // Fetching Image
        image = "Sorry, No Image Available!"
        if (content.image != "undefined")
            image = '<img src="' + content.image + '" alt="' + content.title + '">'
        $('#recipe_image').html(image)
    })
    .catch (error => {
        console.log(error)
    })
}

/* recipe_search
 * Input: N/A
 * Purpose: Using a fetch request to search for a recipe matching specific
 *          qualifications
 * Output: N/A
 */
function recipe_search() {
    num_results = 5;
    search_term = generate_search()
    
    url = url_search_constructor(search_term, num_results)

    res = fetch(url)
    .then (res => res.text())
    .then (data => {
        // Parsing Data
        result = JSON.parse(data);

        // TODO: ....this...

        // console.log(result)
        // content = result.recipes[0]

        // // Fetching Title
        // $('#recipe_title').text(content.title);

        // // Fetching Ingredients
        // ingredient_list = "<ul>\n"
        // for (i = 0; i < content.extendedIngredients.length; i++) {
        //     ingredient_list += "\t<li>" + JSON.stringify(content.extendedIngredients[i].original).substring(1, JSON.stringify(result.recipes[0].extendedIngredients[i].original).length - 1) + "</li>\n"
        // }    
        // ingredient_list += "</ul>\n"
        // $('#recipe_ingredients').html(ingredient_list)

        // // Fetching Image
        // $('#recipe_ingredients').html(ingredient_list)
    })
    .catch (error => {
        console.log(error)
    })
}



/* url_search_constructor
 * Input: A dictionary of key-value pairs that describe what to search by as
 *        well as an integer indicating the number of results to return
 * Purpose: Turns the dictionary of search into a url than can be fetch
 *          requested
 * Output: The url to perform a complex search request
 */
function url_search_constructor(search_term, num_results) {
    url = "https://api.spoonacular.com/recipes/complexSearch?";


    for (key in search_term) {
        url += key + "=" + search_term[key] + "&"
    }

    url += "number=" + num_results + "&apiKey=bd18dc08d7954c4cae19b14f4f47eda8"
    return url;
}


/* generate_search
 * Input: N/A
 * Purpose: Generates a dictionary that corresponds to a user-inputted recipe
 *          category search
 * Output: The dictionary of search terms and values
 */
function generate_search() {
    // TODO:
    // search_term = {}
    search_term = {"query": "pasta", "maxFat": 25} // Dummy For Now

    return search_term;
}

// String Helper Functions!
get_position = (str, m, i) => str.split(m, i).join(m).length;
segment = (str, m, i) => str.slice(0, get_position(str, m, i) + 1)