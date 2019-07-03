import Vue from 'vue';
import vSelect from 'vue-select';

vSelect.props.components.default = () => ({
  Deselect: {
    render: createElement => createElement('span', '❌'),
  },
  OpenIndicator: {
    render: createElement => createElement('span', '🔽'),
  },
});