
// const KEY = "bd18dc08d7954c4cae19b14f4f47eda8"
// const KEY = "79488a502b0548a2a5c775147fe33aa4"
const KEY = ""
const test_fetch = "./example_recipe.json"
console.log("Note: Turning API Calls Off Temporarily to Preserve Spoonacular Points!\nUsing `example_recipe.json` file instead")

/* fetch_random
 * Input: N/A
 * Purpose: Using a fetch request to attain a random recipe from the Spoonacular
 *          API
 * Output: N/A
 */
async function fetch_random(){
    // Performing Fetch
    url = `https://api.spoonacular.com/recipes/random?number=1&apiKey=${KEY}`
    url = test_fetch // TODO: Remove
    result = await fetch_req(url)

    if (content === null) return;
    
    // Main Recipe Content
    content = result.recipes[0]

    // Attaining Title
    $('#recipe_title').text(content.title);

    // Attaining Summary
    // Segments the Summary String For More Digestable Output
    summary = segment(content.summary, '.', 4)
    $('#recipe_summary').html(summary);

    // Attaining Image
    image = "Sorry, No Image Available!"
    if (content.image != "undefined")
        image = `<img src="${content.image}" alt="${content.title}">`
    $('#recipe_image').html(image)
}

/* recipe_search
 * Input: N/A
 * Purpose: Using a fetch request to search for a recipe matching specific
 *          qualifications
 * Output: N/A
 */
async function recipe_search() {
    // Constructing & Fetching Search URL
    num_results = 3;
    search_terms = generate_search()
    search_url = url_search_constructor(search_terms, num_results)
    
    // result = await fetch_req(search_url)
    // if (result === null) return;


    // // Parsing Search Results for Product IDs
    // items = result['results']
    // ids = []
    // items.forEach(item => { ids.push(item['id']) });

    // id_urls = []
    // ids.forEach(id => { 
    //     id_urls.push(`https://api.spoonacular.com/recipes/${id}/information?apiKey=${KEY}`) 
    // });


    // Filling Correct HTML Block With Info
    document.getElementById("search_results").innerHTML = ""
    success = true;

    id_urls = [test_fetch] // TODO: Remove
    content = []
    for (i = 0; i < id_urls.length; i = i) {
        curr_content = await fetch_req(id_urls[i])
        // console.log(curr_content)
        content.push(curr_content)
        success = await build_search_result(id_urls[i], i++, curr_content) && success
        break
    }

    if (!success)
       document.getElementById("search_results").innerHTML = "<p><em>Sorry, an error has occurred. Please Try Again.</em></p>"

}

async function build_search_result(url, id_num, content) {
    // Performing Fetch
    if (content === null) return false;

    console.log(content)
    overall_price = content.pricePerServing * content.servings / 100
    message =
`<div class="search_result" id="result_${id_num}" style="align-items: center">
    <h4 id="title_${id_num}">${content.title}</h4>
    <input type="checkbox" id="id_${id_num}" name="name_${id_num}" value="value_${id_num}">
    <label for="id_${id_num}">Select For Addition!</label>
    
    <div class="json">
        <input type='hidden' name='json_${id_num}_title' value='${content.title}'/>
        <input type='hidden' name='json_${id_num}_summary' value='${content.summary}'/>
        <input type='hidden' name='json_${id_num}_price' value='${overall_price}'/>
        <input type='hidden' name='json_${id_num}_ingredients' value='${JSON.stringify(content.extendedIngredients)}'/>
    </div>
</div>
`
    // <div  class="json" id="json_${id_num}" name="json_${id_num}">${JSON.stringify(content)}</div>
    // <input type="checkbox" id="fruit1" name="name_${id_num}" value="value_${id_num}">
    // <label for="name_${id_num}">Select For Addition!</label>
    // <button type="button" id="search" style="width: 300px">Select for Addition!</button>

    // <h4 id="b2_${id_num}" style="grid-area: button2">Button 2</h4>
    /* <img src="${content.image}" alt="${content.title} style="grid-area: image"> */


    
    document.getElementById("search_results").innerHTML += message
    return true;
}



/* url_search_constructor
 * Input: A dictionary of key-value pairs that describe what to search by as
 *        well as an integer indicating the number of results to return
 * Purpose: Turns the dictionary of search into a url than can be fetch
 *          requested
 * Output: The url to perform a complex search request
 */
function url_search_constructor(search_term, num_results) {
    url = "https://api.spoonacular.com/recipes/complexSearch?instructionsRequired=true&";

    camel_search = []
    search_term.forEach(element => {
        camel_search.push(camelize(element))
    });

    camel_search.forEach(element => {
        url += `${element}=true&`
    });

    url += `number=${num_results}&apiKey=${KEY}`
    
    return url;
}

/* generate_search
 * Input: N/A
 * Purpose: Generates a dictionary that corresponds to a user-inputted recipe
 *          category search
 * Output: The dictionary of search terms and values
 */
function generate_search() {
    options = [...document.getElementsByClassName("drop-display")][0],
              descendants = options.getElementsByTagName('*');
    
    search_terms = []
    for (item of descendants) {
        class_name = item.className.trim()

        if (class_name == "item" || class_name == "item add") {
            text = item.textContent
            text = text.slice(0, text.length - 1).trim()

            search_terms.push(text)
        }
    }

    return search_terms;
}


/* fetch_req
 * Inputs:  The url corresponding to the data to be fetched
 * Purpose: To perform a fetch request on a given url
 * Return:  If successful, return the parsed data found on request 
 *          Else, prints an error to the console log and returns null
 */
async function fetch_req(url) {
    const response = await fetch(url);

    if (!response.ok) {
        console.log(`An error has occured: ${response.status}`);
        return null;
    }

    const response_json = await response.json();
    return response_json;
}

function read_data() {
    // json = [...document.getElementsByClassName("json")]

    // console.log(json)

    // json.forEach(option => {
    //     console.log(option)
    // });



    // search_terms = []
    // for (item of descendants) {
    //     class_name = item.className.trim()

    //     if (class_name == "item" || class_name == "item add") {
    //         text = item.textContent
    //         text = text.slice(0, text.length - 1).trim()

    //         search_terms.push(text)
    //     }
    // }

    // return search_terms;
}



/* # * # * # * # *    String Helper Functions!    * # * # * # * # */
get_position = (str, m, i) => str.split(m, i).join(m).length;

segment = (str, m, i) => str.slice(0, get_position(str, m, i) + 1)

function camelize(str) {
  return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(word, index) {
    return index === 0 ? word.toLowerCase() : word.toUpperCase();
  }).replace(/\s+/g, '');
}

