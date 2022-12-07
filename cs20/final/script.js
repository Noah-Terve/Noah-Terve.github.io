/* fetch_random
 * Input: N/A
 * Purpose: Using a fetch request to attain a random recipe from the Spoonacular
 *          API
 * Output: N/A
 */

const KEY = "bd18dc08d7954c4cae19b14f4f47eda8"

async function fetch_random(){
    // Performing Fetch
    url = `https://api.spoonacular.com/recipes/random?number=1&apiKey=${KEY}`
    result = await fetch_req(url)
    
    // Main Recipe Content
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
    
    // console.log(search_url)
    
    result = await fetch_req(search_url)


    // Parsing Search Results for Product IDs
    items = result['results']
    ids = []
    items.forEach(item => { ids.push(item['id']) });

    id_urls = []
    ids.forEach(id => { 
        id_urls.push(`https://api.spoonacular.com/recipes/${id}/information?apiKey=${KEY}`) 
    });

    console.log(id_urls)
    
    
    
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

async function fetchMovies() {
  const response = await fetch('/movies');
  // waits until the request completes...
  console.log(response);
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


async function fetch_req(url) {
    const response = await fetch(url);

    if (!response.ok) {
        const err = `An error has occured: ${response.status}`;
        console.log(err);
    }

    const response_json = await response.json();
    return response_json;
}



/* # * # * # * # *    String Helper Functions!    * # * # * # * # */
get_position = (str, m, i) => str.split(m, i).join(m).length;

segment = (str, m, i) => str.slice(0, get_position(str, m, i) + 1)

function camelize(str) {
  return str.replace(/(?:^\w|[A-Z]|\b\w)/g, function(word, index) {
    return index === 0 ? word.toLowerCase() : word.toUpperCase();
  }).replace(/\s+/g, '');
}

