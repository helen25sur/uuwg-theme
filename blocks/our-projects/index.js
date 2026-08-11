(function (blocks, element, blockEditor, components, i18n, data) {

  const { registerBlockType } = blocks;
  const { useBlockProps, InspectorControls, RichText } = blockEditor;

  // Виправлено: беремо TextControl
  const { PanelBody, TextControl, Spinner } = components;
  const NumberControl = components.NumberControl || components.__experimentalNumberControl || TextControl;

  const { __ } = i18n;
  const { useSelect } = data;
  const el = element.createElement;

  registerBlockType('uuwg/our-projects', {
    edit: function (props) {
      const { attributes, setAttributes } = props;
      const { heading, buttonText, buttonUrl, countOfProjects } = attributes;

      const blockProps = useBlockProps({ className: 'uuwg-our-projects' });

      // 1. Отримуємо реальні записи CPT 'project' через REST API
      const projects = useSelect(
        function (select) {
          return select('core').getEntityRecords('postType', 'project', {
            per_page: countOfProjects,
            _embed: true, // щоб завантажити зображення записів
          });
        },
        [countOfProjects]
      );

      // 2. Сайдбар налаштувань
      const inspector = el(
        InspectorControls,
        {},
        el(
          PanelBody,
          { title: __('Налаштування блоку', 'uuwg'), initialOpen: true },
          el(TextControl, {
            label: __('Кількість проєктів', 'uuwg'),
            type: 'number',
            value: countOfProjects,
            min: 1,
            max: 12,
            onChange: (v) => setAttributes({ countOfProjects: parseInt(v, 10) || 1 }),
          }),
          el(TextControl, {
            label: __('URL кнопки', 'uuwg'),
            value: buttonUrl,
            onChange: (v) => setAttributes({ buttonUrl: v }),
          })
        )
      );

      // 3. Формування сітки проєктів (стан завантаження / списку)
      let projectsGrid;

      if (projects === null) {
        projectsGrid = el(
          'div',
          { className: 'uuwg-our-projects__loading' },
          el(Spinner),
          ' ',
          __('Завантаження проєктів...', 'uuwg')
        );
      } else if (projects.length === 0) {
        projectsGrid = el(
          'p',
          { className: 'uuwg-our-projects__empty' },
          __('Проєктів не знайдено. Створіть записи CPT "project".', 'uuwg')
        );
      } else {
        projectsGrid = projects.map(function (project) {
          // Отримуємо мініатюру запису, якщо вона існує
          const media = project._embedded && project._embedded['wp:featuredmedia'] && project._embedded['wp:featuredmedia'][0];
          const imageUrl = media ? (media.media_details?.sizes?.medium?.source_url || media.source_url) : null;

          return el(
            'div',
            { className: 'uuwg-our-projects__card', key: project.id },
            imageUrl && el('img', { src: imageUrl, alt: project.title.rendered, className: 'uuwg-our-projects__card-img' }),
            el(
              'div',
              { className: 'uuwg-our-projects__card__content' },
              el('h3', {
                className: 'uuwg-our-projects__card__title',
                dangerouslySetInnerHTML: { __html: project.title.rendered },
              }),
              el('span', { className: 'uwg-our-projects__card__button' }, __('Read more', 'uuwg'))
            )
          );
        });
      }

      // 4. Повертаємо розмітку блоку
      return el(
        'div',
        blockProps,
        inspector,
        el(
          'div',
          { className: 'uuwg-our-projects__content' },
          el(
            'div',
            { className: 'uuwg-our-projects__header' },
            el(RichText, {
              tagName: 'h2',
              className: 'uuwg-our-projects__heading',
              value: heading,
              onChange: (v) => setAttributes({ heading: v }),
              placeholder: __('Заголовок...', 'uuwg'),
              allowedFormats: [],
            }),
            el(RichText, {
              tagName: 'span',
              className: 'uuwg-our-projects__cta uuwg-btn',
              value: buttonText,
              onChange: (v) => setAttributes({ buttonText: v }),
              placeholder: __('Текст кнопки...', 'uuwg'),
              allowedFormats: [],
            })
          ),
          el('div', { className: 'uuwg-our-projects__grids' }, projectsGrid)
        )
      );
    },

    save: function () {
      return null;
    },

  });

})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components,
  window.wp.i18n,
  window.wp.data
);