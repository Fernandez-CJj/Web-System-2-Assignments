import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const photoModal = document.querySelector('[data-image-modal]');

    if (photoModal) {
        const modalImage = photoModal.querySelector('[data-image-modal-image]');
        const modalCaption = photoModal.querySelector('[data-image-modal-caption]');
        const closeButtons = photoModal.querySelectorAll('[data-image-modal-close]');
        let previousFocus = null;

        const closePhotoModal = () => {
            photoModal.hidden = true;
            document.body.classList.remove('photo-modal-open');
            modalImage.removeAttribute('src');

            if (previousFocus) {
                previousFocus.focus();
            }
        };

        const openPhotoModal = (trigger) => {
            previousFocus = trigger;
            modalImage.src = trigger.dataset.imageModalSrc;
            modalImage.alt = trigger.dataset.imageModalTitle;
            modalCaption.textContent = trigger.dataset.imageModalTitle;
            photoModal.hidden = false;
            document.body.classList.add('photo-modal-open');
            photoModal.querySelector('.photo-modal-close').focus();
        };

        document.addEventListener('click', (event) => {
            const trigger = event.target.closest('[data-image-modal-trigger]');

            if (trigger) {
                event.preventDefault();
                event.stopPropagation();
                openPhotoModal(trigger);
            }
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', closePhotoModal);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && ! photoModal.hidden) {
                closePhotoModal();
            }
        });
    }

    const itemModal = document.querySelector('[data-item-modal]');

    if (itemModal) {
        const modalContent = itemModal.querySelector('[data-item-modal-content]');
        const closeButtons = itemModal.querySelectorAll('[data-item-modal-close]');
        let previousFocus = null;

        const closeItemModal = () => {
            itemModal.hidden = true;
            document.body.classList.remove('item-modal-open');
            modalContent.innerHTML = '';

            if (previousFocus) {
                previousFocus.focus();
            }
        };

        const openItemModal = (card) => {
            const template = card.querySelector('[data-item-detail-template]');

            if (! template) {
                return;
            }

            previousFocus = card;
            modalContent.innerHTML = template.innerHTML;
            itemModal.hidden = false;
            document.body.classList.add('item-modal-open');
            itemModal.querySelector('.item-modal-close').focus();
        };

        const isCardControl = (target) => Boolean(target.closest(
            'a, button, input, select, textarea, label, form, [data-image-modal-trigger]'
        ));

        document.querySelectorAll('[data-item-detail-trigger]').forEach((card) => {
            card.addEventListener('click', (event) => {
                if (! isCardControl(event.target)) {
                    openItemModal(card);
                }
            });

            card.addEventListener('keydown', (event) => {
                if ((event.key === 'Enter' || event.key === ' ') && ! isCardControl(event.target)) {
                    event.preventDefault();
                    openItemModal(card);
                }
            });
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', closeItemModal);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && ! itemModal.hidden && (! photoModal || photoModal.hidden)) {
                closeItemModal();
            }
        });
    }

    const tradeModal = document.querySelector('[data-trade-modal]');

    if (tradeModal) {
        const modalContent = tradeModal.querySelector('[data-trade-modal-content]');
        const closeButtons = tradeModal.querySelectorAll('[data-trade-modal-close]');
        let previousFocus = null;

        const closeTradeModal = () => {
            tradeModal.hidden = true;
            document.body.classList.remove('trade-modal-open');
            modalContent.innerHTML = '';

            if (previousFocus) {
                previousFocus.focus();
            }
        };

        const openTradeModal = (card) => {
            const template = card.querySelector('[data-trade-detail-template]');

            if (! template) {
                return;
            }

            previousFocus = card;
            modalContent.innerHTML = template.innerHTML;
            tradeModal.hidden = false;
            document.body.classList.add('trade-modal-open');
            tradeModal.querySelector('.trade-modal-close').focus();
        };

        const isTradeCardControl = (target) => Boolean(target.closest(
            'a, button, input, select, textarea, label, form, [data-image-modal-trigger]'
        ));

        document.querySelectorAll('[data-trade-detail-trigger]').forEach((card) => {
            card.addEventListener('click', (event) => {
                if (! isTradeCardControl(event.target)) {
                    openTradeModal(card);
                }
            });

            card.addEventListener('keydown', (event) => {
                if ((event.key === 'Enter' || event.key === ' ') && ! isTradeCardControl(event.target)) {
                    event.preventDefault();
                    openTradeModal(card);
                }
            });
        });

        closeButtons.forEach((button) => {
            button.addEventListener('click', closeTradeModal);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && ! tradeModal.hidden && (! photoModal || photoModal.hidden)) {
                closeTradeModal();
            }
        });
    }

    document.querySelectorAll('[data-image-upload]').forEach((upload) => {
        const input = upload.querySelector('[data-image-upload-input]');
        const preview = upload.querySelector('[data-image-upload-preview]');
        const maxFiles = Number(upload.dataset.imageUploadMax || 0);
        let selectedFiles = [];
        let objectUrls = [];

        const syncInput = () => {
            const transfer = new DataTransfer();

            selectedFiles.forEach((file) => transfer.items.add(file));
            input.files = transfer.files;
        };

        const clearObjectUrls = () => {
            objectUrls.forEach((url) => URL.revokeObjectURL(url));
            objectUrls = [];
        };

        const renderPreviews = () => {
            clearObjectUrls();
            preview.innerHTML = '';

            selectedFiles.forEach((file, index) => {
                const url = URL.createObjectURL(file);
                objectUrls.push(url);

                const card = document.createElement('div');
                card.className = 'image-preview-card';

                const image = document.createElement('img');
                image.src = url;
                image.alt = `${file.name} preview`;

                const meta = document.createElement('div');
                meta.className = 'image-preview-meta';

                const name = document.createElement('span');
                name.textContent = file.name;

                const remove = document.createElement('button');
                remove.type = 'button';
                remove.textContent = 'Remove';
                remove.setAttribute('aria-label', `Remove ${file.name}`);
                remove.addEventListener('click', () => {
                    selectedFiles.splice(index, 1);
                    syncInput();
                    renderPreviews();
                });

                meta.append(name, remove);
                card.append(image, meta);
                preview.append(card);
            });
        };

        input.addEventListener('change', () => {
            const nextFiles = Array.from(input.files);
            const filesBySignature = new Map();

            [...selectedFiles, ...nextFiles].forEach((file) => {
                const signature = `${file.name}-${file.size}-${file.lastModified}`;

                if (! filesBySignature.has(signature)) {
                    filesBySignature.set(signature, file);
                }
            });

            selectedFiles = Array.from(filesBySignature.values());

            if (maxFiles > 0) {
                selectedFiles = selectedFiles.slice(0, maxFiles);
            }

            syncInput();
            renderPreviews();
        });
    });

    const selects = document.querySelectorAll('[data-multi-select]');

    selects.forEach((select) => {
        const toggle = select.querySelector('[data-multi-select-toggle]');
        const menu = select.querySelector('[data-multi-select-menu]');
        const label = select.querySelector('[data-multi-select-label]');
        const tags = select.querySelector('[data-multi-select-tags]');
        const options = Array.from(select.querySelectorAll('[data-multi-select-option]'));
        const name = select.dataset.name;
        const max = Number(select.dataset.max || 0);
        const placeholder = select.dataset.placeholder || 'Select options';

        const selectedValues = () => Array.from(tags.querySelectorAll('[data-multi-select-chip]'))
            .map((chip) => chip.dataset.value);

        const sync = () => {
            const selected = selectedValues();
            label.textContent = selected.length === 0
                ? placeholder
                : selected.length === 1
                    ? selected[0]
                    : `${selected.length} selected`;

            options.forEach((option) => {
                const isSelected = selected.includes(option.dataset.value);
                option.setAttribute('aria-selected', String(isSelected));
                option.classList.toggle('selected', isSelected);
            });
        };

        const makeChip = (value) => {
            const chip = document.createElement('span');
            chip.className = 'selected-tag';
            chip.dataset.multiSelectChip = '';
            chip.dataset.value = value;

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `${name}[]`;
            input.value = value;

            const text = document.createElement('span');
            text.textContent = value;

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.dataset.multiSelectRemove = '';
            remove.setAttribute('aria-label', `Remove ${value}`);
            remove.textContent = 'x';

            chip.append(input, text, remove);

            return chip;
        };

        const removeValue = (value) => {
            Array.from(tags.querySelectorAll('[data-multi-select-chip]'))
                .find((chip) => chip.dataset.value === value)
                ?.remove();
            sync();
        };

        const addValue = (value) => {
            const selected = selectedValues();

            if (selected.includes(value)) {
                removeValue(value);
                return;
            }

            if (max > 0 && selected.length >= max) {
                return;
            }

            tags.append(makeChip(value));
            sync();
        };

        const setOpen = (open) => {
            menu.hidden = !open;
            toggle.setAttribute('aria-expanded', String(open));
            select.classList.toggle('open', open);
        };

        toggle.addEventListener('click', () => setOpen(menu.hidden));

        options.forEach((option) => {
            option.addEventListener('click', () => addValue(option.dataset.value));
        });

        tags.addEventListener('click', (event) => {
            const remove = event.target.closest('[data-multi-select-remove]');

            if (remove) {
                removeValue(remove.closest('[data-multi-select-chip]').dataset.value);
            }
        });

        document.addEventListener('click', (event) => {
            if (! select.contains(event.target)) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        });

        sync();
    });
});
