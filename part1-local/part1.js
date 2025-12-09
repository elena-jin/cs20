// part1.js
// Node script that reads companies-1.csv line by line and inserts into MongoDB
import fs from "fs";
import readline from "readline";
import { MongoClient } from "mongodb";
import dotenv from "dotenv";

dotenv.config();

const uri = process.env.MONGODB_URI;
const dbName = process.env.DB_NAME || "Stock";
const collName = process.env.COLLECTION_NAME || "PublicCompanies";
const csvFile = process.env.CSV_FILE || "companies-1.csv";

if (!uri) {
  console.error("Missing MONGODB_URI in .env");
  process.exit(1);
}

async function main() {
  const client = new MongoClient(uri);
  try {
    await client.connect();
    const db = client.db(dbName);
    const coll = db.collection(collName);

    // Read file one line at a time so it doesn't die
    const stream = fs.createReadStream(csvFile);
    const rl = readline.createInterface({ input: stream, crlfDelay: Infinity });

    let lineNum = 0;
    const bulkOps = [];
    for await (const line of rl) {
      lineNum++;
      const trimmed = line.trim();
      if (!trimmed) continue;

      // Skip header line (we assume the first line is header)
      if (lineNum === 1 && /Company\s+Ticker\s+Price/i.test(trimmed)) {
        console.log("Skipping header:", trimmed);
        continue;
      }

      // Parse line: company name may contain spaces; assume last two tokens are ticker and price.
      // split on whitespace, take last token = price, second to last = ticker, rest join as name
      const parts = trimmed.split(/\s+/);
      if (parts.length < 3) {
        console.warn(`Skipping invalid line ${lineNum}: ${line}`);
        continue;
      }
      const priceStr = parts[parts.length - 1];
      const ticker = parts[parts.length - 2];
      const companyName = parts.slice(0, parts.length - 2).join(" ");

      const price = Number(priceStr);
      if (Number.isNaN(price)) {
        console.warn(`Invalid price on line ${lineNum}: ${priceStr}`);
        continue;
      }

      console.log(`Line ${lineNum}:`, { companyName, ticker, price });

      // Build  doc for project
      const doc = {
        name: companyName,
        ticker: ticker,
        price: price,
        importedAt: new Date()
      };

      bulkOps.push({ insertOne: { document: doc } });

      // await so that file doesn't die, we load as it goes
      if (bulkOps.length >= 500) {
        await coll.bulkWrite(bulkOps);
        bulkOps.length = 0;
      }
    }

    if (bulkOps.length > 0) {
      await coll.bulkWrite(bulkOps);
    }

    console.log("Done inserting data.");
  } catch (err) {
    console.error("Error:", err);
  } finally {
    await client.close();
  }
}

main();
