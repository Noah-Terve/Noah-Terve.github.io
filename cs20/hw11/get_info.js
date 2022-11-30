var http = require('http');
var url = require('url');
var MongoClient = require('mongodb').MongoClient;
var mongo_url = "mongodb+srv://terve:terve@cluster0.vluoaxo.mongodb.net/?retryWrites=true&w=majority";
const client = new MongoClient(mongo_url);
var data;

async function get_data(input, type) {
    if (!input) return;
    await client.connect();
    console.log("identifier is: " + input + "\nType is: " + type)
    console.log('Connected successfully to server');
    var db = client.db("stock-app");
    var collection = db.collection('equities');

    var docs;
    if (type) docs = await collection.find({ name : input}).toArray();
    else docs = await collection.find({ ticker : input}).toArray();
    
    console.log(docs);
    var filtered_docs = [];
    docs.forEach(element => {
        filtered_docs.push(element.name);
        filtered_docs.push(element.ticker);
    });
    data = filtered_docs;
}

http.createServer(async function (req, res) {
    var qobj = url.parse(req.url, true).query;
    var type = false; // true means they gave a name, false means they gave a ticker
    if (qobj.name) {type = true} // if the company name exists then set value to be true

    console.log("About to try to open connection")

    await get_data(qobj.identifier, type)
        .then(() => client.close())
        .catch(console.error);
    
    console.log(data);
    var response = ""

    for (i = 0; i < data.length; i += 2) {
        response += "<p>Company Name: " + data[i] + ", Company Ticker: " + data[i + 1] + "</p>";
    }
    if (data.length == 0) {
        response = "There were no companies matching that identifier in the database.";
    }

    res.writeHead(200, {'Content-Type': 'text/html'});
    res.write(response)
    res.end();
}).listen(8080);