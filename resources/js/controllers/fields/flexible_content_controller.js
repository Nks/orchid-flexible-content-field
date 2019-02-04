import {Controller} from "stimulus"

import dragula from "dragula";

let sqrl = require('squirrelly');

let $ = global.$;

export default class extends Controller {
    /**
     * @type {string[]}
     */
    static targets = [
        "layout",
        "blocks",
        "content"
    ];

    layouts = {};

    connect() {
        console.log('init');
        this.fetchLayouts();
        this.initDragDrop();
    }

    layoutSelect(event) {
        event.preventDefault();

        let selectedLayout = event.target,
            layoutName = event.target.dataset.layout;

        if (!(layoutName in this.layouts)) {
            window.platform.alert(`Can't fetch layout ${layoutName}`, 'error');

            return false;
        }

        const layout = this.layouts[layoutName];

        this.draw(layoutName, layout, selectedLayout);

        this.checkEmpty();
    }

    draw(name, layout, original) {
        let html = layout.element.innerHTML,
            index = original.dataset.index,
            count = this.blocksTarget.querySelectorAll('.layout').length;

        html = html.replace(new RegExp(index, 'g'), count);

        this.blocksTarget.insertAdjacentHTML('beforeend', html);
    }

    checkEmpty() {
        this.contentTarget.classList.toggle('empty', !this.blocksTarget.querySelectorAll('.flexible-content-layout').length === 0);
    }

    delete(event) {
        console.log(event);

        event.target.closest('.layout').remove();

        this.sort();
    }

    fetchLayouts() {
        this.layoutTargets.forEach((layout, index) => {
            const name = layout.dataset.name;

            if (name in this.layouts) {
                return;
            }

            this.layouts[name] = {
                element: layout,
                name: name
            };
        });
    }

    /**
     * Initialize drag n' drop ability
     */
    initDragDrop() {
        let self = this;

        dragula([this.blocksTarget], {
            moves: function (el, container, handle) {
                return handle.classList.contains('card-handle');
            }
        }).on('drop', function () {
            self.sort();
        });
    }

    sort() {
    }

    disconnect() {
        this.blocksTarget.innerHTML = '';
    }

}