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
        
        // Fetching Title
        $('#recipe_title').text(result.recipes[0].title);

        // Fetching Ingredients
        ingredient_list = "<ul>\n"
        for (i = 0; i < result.recipes[0].extendedIngredients.length; i++) {
            ingredient_list += "\t<li>" + JSON.stringify(result.recipes[0].extendedIngredients[i].original).substring(1, JSON.stringify(result.recipes[0].extendedIngredients[i].original).length - 1) + "</li>\n"
        }    
        ingredient_list += "</ul>\n"
        $('#recipe_ingredients').html(ingredient_list)

        // Fetching Image
        $('#recipe_ingredients').html(ingredient_list)
    })
    .catch (error => {
        console.log(error)
    })
}