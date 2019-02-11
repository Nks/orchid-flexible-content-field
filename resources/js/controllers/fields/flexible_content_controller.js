import {Controller} from "stimulus"

import dragula from "dragula";

export default class extends Controller {
    /**
     * @type {string[]}
     */
    static targets = [
        "layout",
        "blocks",
        "content",
        "layoutIndex"
    ];

    layouts = {};

    uniqidSeed = '';

    connect() {
        this.fetchLayouts();
        this.initDragDrop();
        this.checkEmpty();
        this.reorder();
    }

    /**
     * Fetching layouts
     */
    fetchLayouts() {
        this.layoutTargets.forEach((layout) => {
            const name = layout.dataset.name;

            if (name in this.layouts) {
                return;
            }

            this.layouts[name] = {
                name: name,
                element: layout
            };
        });

        return this;
    }

    /**
     * Select layout listener. Adding layout when it selected from the dropdown.
     *
     * @param event
     * @returns {boolean}
     */
    layoutSelect(event) {
        event.preventDefault();

        let selectedLayout = event.target,
            layoutName = event.target.dataset.layout;

        if (!(layoutName in this.layouts)) {
            window.platform.alert(`Can't fetch layout ${layoutName}`, 'danger');

            return false;
        }

        const layout = this.layouts[layoutName];

        this.draw(layoutName, layout, selectedLayout)
            .reorder()
            .checkEmpty();
    }

    /**
     * Draw the layout
     *
     * @param name
     * @param layout
     * @param original
     */
    draw(name, layout, original) {
        let html = layout.element.innerHTML,
            index = original.dataset.index,
            key = this.getKey();

        html = html
            .replace(new RegExp(index, 'g'), key)
            .replace(new RegExp('data-fc_key=""'), 'data-fc_key="' + key + '"');

        this.blocksTarget.insertAdjacentHTML('beforeend', html);

        return this;
    }

    /**
     * Show or hide empty message.
     */
    checkEmpty() {
        this.contentTarget.classList.toggle('empty', !(this.blocksTarget.querySelectorAll('.layout').length > 0));

        return this;
    }

    /**
     * Return
     *
     * @param event
     */
    delete(event) {
        event.target.closest('.layout').remove();

        this.checkEmpty().reorder();

        return this;
    }

    /**
     * Initialize drag n' drop ability
     */
    initDragDrop() {
        let self = this;

        dragula([this.blocksTarget], {
            moves: function (el, container, handle) {
                let isCorrectHandle = (handle.dataset.parentContainerKey === self.blocksTarget.dataset.containerKey);

                return handle.classList.contains('card-handle') && isCorrectHandle;
            }
        }).on('drop', function () {
            self.reorder();
        });

        return this;
    }

    /**
     * Generate truly random key
     *
     * @returns {string}
     */
    getKey() {
        let possibleKey = this.uniqid('fc_');

        if (this.blocksTarget.querySelectorAll('.layout[data-fc_key="' + possibleKey + '"]').length) {
            possibleKey = this.getKey();
        }

        return possibleKey;
    }

    /**
     * Reordering all blocks to keep order correct
     */
    reorder() {
        this.blocksTarget.querySelectorAll('.layout[data-fc_key]').forEach((block) => {
            const newKey = this.getKey(),
                oldKey = block.dataset.fc_key;

            block.dataset.fc_key = newKey;

            let inputs = block.querySelectorAll('[name*="' + oldKey + '"]');

            inputs.forEach((input) => {
                const oldName = input.getAttribute('name'),
                    newName = oldName.replace(new RegExp(oldKey, 'g'), newKey);

                input.setAttribute('name', newName);
            });
        });

        this.layoutIndexTargets.forEach((index, key) => {
            index.innerHTML = key + 1;
        });

        return this;
    }

    /**
     * Generating the unique id
     *
     * @param prefix
     * @param moreEntropy
     * @returns {*}
     */
    uniqid(prefix, moreEntropy) {
        if (typeof prefix === 'undefined') {
            prefix = '';
        }

        let retId;
        let formatSeed = function (seed, reqWidth) {
            seed = parseInt(seed, 10).toString(16); // to hex str
            if (reqWidth < seed.length) { // so long we split
                return seed.slice(seed.length - reqWidth);
            }
            if (reqWidth > seed.length) { // so short we pad
                return Array(1 + (reqWidth - seed.length)).join('0') + seed;
            }
            return seed;
        };

        if (!this.uniqidSeed) { // init seed with big random int
            this.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
        }
        this.uniqidSeed++;

        retId = prefix; // start with prefix, add current milliseconds hex string
        retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
        retId += formatSeed(this.uniqidSeed, 5); // add seed hex string
        if (moreEntropy) {
            // for more entropy we add a float lower to 10
            retId += (Math.random() * 10).toFixed(8).toString();
        }

        return retId;
    }

    /**
     * Removing blocks to prevent issues with turbolinks
     */
    disconnect() {
        this.blocksTarget.innerHTML = '';
    }

}