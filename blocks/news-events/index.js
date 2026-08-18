(function (blocks, element, blockEditor, components, i18n, data) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  const { PanelBody, TextControl, ToggleControl, Spinner } = components;
  const { __, sprintf } = i18n;
  const { useSelect } = data;
  const el = element.createElement;

  registerBlockType('uuwg/news-events', {
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl, countOfNews, showPagination, showHeaderButton } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-news-events alignfull' });

      const { news, totalPages } = useSelect(
        function (select) {
          const query = { per_page: countOfNews, _embed: true };
          return {
            news: select('core').getEntityRecords('postType', 'news_event', query),
            totalPages: select('core').getEntityRecordsTotalPages('postType', 'news_event', query) || 1,
          };
        },
        [countOfNews]
      );

      const inspector = el(
        InspectorControls,
        {},
        el(
          PanelBody,
          { title: __('Block Settings', 'uuwg'), initialOpen: true },
          el(TextControl, {
            label: __('Count of News', 'uuwg'),
            type: 'number',
            value: countOfNews,
            min: 1,
            max: 12,
            onChange: (v) => setAttributes({ countOfNews: parseInt(v, 10) || 1 }),
          }),
          el(ToggleControl, {
            label: __('Show pagination', 'uuwg'),
            checked: showPagination,
            onChange: (v) => setAttributes({ showPagination: v }),
          }),
          // ТОГЛЕР КНОПКИ
          el(ToggleControl, {
            label: __('Show header button', 'uuwg'),
            checked: showHeaderButton,
            onChange: (v) => setAttributes({ showHeaderButton: v }),
          }),
          // ПІДКАЗКА: Ховаємо Button URL, якщо кнопка вимкнена
          showHeaderButton && el(TextControl, {
            label: __('Button URL', 'uuwg'),
            value: buttonUrl,
            onChange: (v) => setAttributes({ buttonUrl: v }),
          })
        )
      );

      let newsGrid;
      if (!news) {
        newsGrid = el('div', { className: 'uuwg-news-events__loading' }, el(Spinner), ' ', __('Loading...', 'uuwg'));
      } else if (news.length === 0) {
        newsGrid = el('p', { className: 'uuwg-news-events__empty' }, __('Not found.', 'uuwg'));
      } else {
        newsGrid = news.map(function (item) {
          const media = item._embedded && item._embedded['wp:featuredmedia'] && item._embedded['wp:featuredmedia'][0];
          const imageUrl = media ? (media.media_details?.sizes?.medium?.source_url || media.source_url) : null;
          const shortDescription = item.short_description || (item.acf && item.acf.short_description) || '';

          return el(
            'div', { className: 'uuwg-news-events__card', key: item.id },
            imageUrl && el('img', { src: imageUrl, alt: item.title.rendered, className: 'uuwg-news-events__card-img' }),
            el('div', { className: 'uuwg-news-events__card__content' },
              el('h3', { className: 'uuwg-news-events__card__title', dangerouslySetInnerHTML: { __html: item.title.rendered } }),
              el('p', { className: 'uuwg-news-events__card__short-description', dangerouslySetInnerHTML: { __html: shortDescription } }),
              el('span', { className: 'uuwg-news-events__card__button wp-element-button' }, __('Read more', 'uuwg'))
            )
          );
        });
      }

      const paginationButtons = [];
      if (showPagination && totalPages > 1) {
        for (let i = 1; i <= totalPages; i++) {
          paginationButtons.push(
            el('button', {
              key: i,
              type: 'button',
              className: 'uuwg-pagination-news-btn' + (i === 1 ? ' is-active' : ''),
              'aria-label': sprintf(__('Page %d', 'uuwg'), i),
              'data-page': i,
            }, i)
          );
        }
      }
      return el(
        'div',
        blockProps,
        inspector,
        el(
          'div', { className: 'uuwg-news-events__content' },
          el('div', { className: 'uuwg-news-events__header' },
            el(RichText, {
              tagName: 'h2',
              className: 'uuwg-news-events__heading',
              value: heading,
              onChange: (v) => setAttributes({ heading: v }),
              placeholder: __('Heading...', 'uuwg')
            }),
            // ЗМІНЕНО: кнопка відображається тільки якщо showHeaderButton === true
            showHeaderButton && el(RichText, {
              tagName: 'span',
              className: 'uuwg-news-events__cta uuwg-btn',
              value: buttonText,
              onChange: (v) => setAttributes({ buttonText: v }),
              placeholder: __('Button text...', 'uuwg')
            })
          ),
          el('div', { className: 'uuwg-news-events__grids js-news-grid' }, newsGrid),
          showPagination && el('div', { className: 'uuwg-news-events__pagination js-news-pagination' }, paginationButtons)
        )
      );
    },
    save: function () { return null; },
  });
})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components,
  window.wp.i18n,
  window.wp.data
);