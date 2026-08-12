(function (blocks, element, blockEditor, components, i18n, data) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;
  // ДОДАНО: ToggleControl
  const { PanelBody, TextControl, ToggleControl, Spinner } = components;
  const { __, sprintf } = i18n;
  const { useSelect } = data;
  const el = element.createElement;

  registerBlockType('uuwg/partners-collaborations', {
    edit: function (props) {
      const { attributes, setAttributes } = props;
      // ДОДАНО: showPagination
      const { heading, buttonText, buttonUrl, countOfProjects, showPagination } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-partners-collaborations' });

      const { projects, totalPages } = useSelect(
        function (select) {
          const query = { per_page: countOfProjects, _embed: true };
          return {
            projects: select('core').getEntityRecords('postType', 'project', query),
            totalPages: select('core').getEntityRecordsTotalPages('postType', 'project', query) || 1,
          };
        },
        [countOfProjects]
      );

      const inspector = el(
        InspectorControls,
        {},
        el(
          PanelBody,
          { title: __('Налаштування блоку', 'uuwg'), initialOpen: true },
          el(TextControl, {
            label: __('Кількість партнерів', 'uuwg'),
            type: 'number',
            value: countOfProjects,
            min: 1,
            max: 12,
            onChange: (v) => setAttributes({ countOfProjects: parseInt(v, 10) || 1 }),
          }),
        )
      );

      // Формування сітки проєктів (залишається без змін)
      let projectsGrid;
      if (projects === null) {
        projectsGrid = el('div', { className: 'uuwg-partners-collaborations__loading' }, el(Spinner), ' ', __('Завантаження...', 'uuwg'));
      } else if (projects.length === 0) {
        projectsGrid = el('p', { className: 'uuwg-partners-collaborations__empty' }, __('Не знайдено.', 'uuwg'));
      } else {
        projectsGrid = projects.map(function (project) {
          const media = project._embedded && project._embedded['wp:featuredmedia'] && project._embedded['wp:featuredmedia'][0];
          const imageUrl = media ? (media.media_details?.sizes?.medium?.source_url || media.source_url) : null;
          return el(
            'div', { className: 'uuwg-partners-collaborations__card', key: project.id },
            imageUrl && el('img', { src: imageUrl, alt: project.title.rendered, className: 'uuwg-partners-collaborations__card-img' }),
            el('div', { className: 'uuwg-partners-collaborations__card__content' },
              el('h3', { className: 'uuwg-partners-collaborations__card__title', dangerouslySetInnerHTML: { __html: project.title.rendered } }),
              el('span', { className: 'uwg-partners-collaborations__card__button' }, __('Read more', 'uuwg'))
            )
          );
        });
      }

      // ЗМІНЕНО: Додана перевірка на showPagination
      const paginationButtons = [];
      if (showPagination && totalPages > 1) {
        for (let i = 1; i <= totalPages; i++) {
          paginationButtons.push(
            el('button', {
              key: i,
              type: 'button',
              className: 'uuwg-pagination-btn' + (i === 1 ? ' is-active' : ''),
              'aria-label': sprintf(__('Сторінка %d', 'uuwg'), i),
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
          'div', { className: 'uuwg-partners-collaborations__content' },
          el('div', { className: 'uuwg-partners-collaborations__header' },
            el(RichText, { tagName: 'h2', className: 'uuwg-partners-collaborations__heading', value: heading, onChange: (v) => setAttributes({ heading: v }), placeholder: __('Заголовок...', 'uuwg') }),
            el(RichText, { tagName: 'span', className: 'uuwg-partners-collaborations__cta uuwg-btn', value: buttonText, onChange: (v) => setAttributes({ buttonText: v }), placeholder: __('Текст кнопки...', 'uuwg') })
          ),
          el('div', { className: 'uuwg-partners-collaborations__grids js-projects-grid' }, projectsGrid),
          // ЗМІНЕНО: Контейнер пагінації рендериться лише якщо вона увімкнена
          showPagination && el('div', { className: 'uuwg-partners-collaborations__pagination js-projects-pagination' }, paginationButtons)
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