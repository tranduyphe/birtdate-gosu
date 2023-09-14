// var mysql = require('mysql');
import mysql from 'mysql';
import * as dotenv from "dotenv";
dotenv.config();

const hostMySQL = process.env.DB_HOST;
const DBMySQL = process.env.DB_NAME;
const userDB = process.env.DB_USER;
const passDB = process.env.DB_PASS;
// var con;
class ConnectDB {
	constructor() {
		this.connection = mysql.createConnection({
            host: hostMySQL,
            user: userDB,
            password: passDB,
            database: DBMySQL
        });
        this.connection.connect(function(err) {
            if (err) throw err;
            console.log("Connected!!!")
        });
	}
	query(sql, args) {
		return new Promise((resolve, reject) => {
			this.connection.query(sql, args, (err, rows) => {
				if (err)
					return reject(err);
				resolve(rows);
			});
		});
	}
	close() {
		return new Promise((resolve, reject) => {
			this.connection.end(err => {
				if (err)
					return reject(err);
				resolve();
			});
		});
	}
}
export default ConnectDB;