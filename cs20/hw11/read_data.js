var fs = require('fs');
var MongoClient = require('mongodb').MongoClient;
var mongo_url = "mongodb+srv://terve:terve@cluster0.vluoaxo.mongodb.net/?retryWrites=true&w=majority";
const client = new MongoClient(mongo_url);
var data_vals_file = "./companies.csv";

var data = fs.readFileSync(data_vals_file, "utf8");
var lines = data.split(/\r?\n/);
var to_insert = [];

lines.forEach(line => {
    var cols = line.split(",");
    if (cols[0] == "Company" || cols[0] == "") {
        return;
    }
    to_insert.push({name: cols[0], ticker: cols[1]});
})

console.log(to_insert)

async function add_in() {

    await client.connect();
    console.log('Connected successfully to server');
    var db = client.db("stock-app");
    var collection = db.collection('equities');

    const insertResult = await collection.insertMany(to_insert);
    console.log('Inserted documents =>', insertResult);

    return 'done.';
}

add_in()
    .then(console.log)
    .catch(console.error)
    .finally(() => client.close());
