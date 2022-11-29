/* fetchdata
 * Input: N/A
 * Purpose: Using a fetch request to attain a random recipe from the Spoonacular
 *          API
 * Output: N/A
 */
function fetchdata(){
    // $('#recipe_title').text("Trial");
    // console.log($('recipe_title').text())
    // document.getElementById("form").style = "display:none"
    // document.getElementById("recipe_title").innerHTML = '<th id="recipe_title">Testtt</th>'

    res = fetch("https://api.spoonacular.com/recipes/random?number=1&apiKey=bd18dc08d7954c4cae19b14f4f47eda8")
    .then (res => res.text())
    .then (data => {
        result = JSON.parse(data);
        // console.log(JSON.stringify(result))
        $('#recipe_title').text(result.recipes[0].title);
        // console.log(result.recipes[0].title)
        // html_string = "<h1>" + JSON.stringify(result.recipes[0].title).substring(1, JSON.stringify(result.recipes[0].title).length - 1)
        //             + "</h1><div>Source: " + JSON.stringify(result.recipes[0].sourceName).substring(1, JSON.stringify(result.recipes[0].sourceName).length - 1)
        //             + "<br />Ingredients: <ul>"
        // ingreds = $('#recipe_ingredients')
        ingredient_list = "<ul>\n"
        for (i = 0; i < result.recipes[0].extendedIngredients.length; i++) {
            ingredient_list += "\t<li>" + JSON.stringify(result.recipes[0].extendedIngredients[i].original).substring(1, JSON.stringify(result.recipes[0].extendedIngredients[i].original).length - 1) + "</li>\n"
        }    
        ingredient_list += "</ul>\n"
        $('#recipe_ingredients').html(ingredient_list)
        // html_string += "</ul>" + JSON.stringify(result.recipes[0].instructions).substring(1, JSON.stringify(result.recipes[0].instructions).length - 1) + "</div>"
        // document.getElementById("recipe_ingredients").innerHTML = html_string
        // document.getElementById("recipe_title").style = "display:none"
        // document.getElementById("form").style = "display:revert"
    })
    .catch (error => {
        console.log(error)
        document.getElementById("recipe_title").style = "display:none"
        // document.getElementById("form").style = "display:revert"
    })
}