import {Controller} from "stimulus"

let sqrl = require('squirrelly');

let $ = global.$;

export default class extends Controller {
    /**
     * @type {string[]}
     */
    static targets = [];

    options = {
        required: false,
        min: null,
        max: null
    };

    connect() {

    }

    disconnect() {
    }

}