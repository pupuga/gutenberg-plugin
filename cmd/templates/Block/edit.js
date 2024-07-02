import EditBlock from '../common/Components/Block/EditBlock';
import fields from './fields';
import './editor.scss';

export default function Edit( props ) {
	return <EditBlock { ...{ ...props, fields: fields } } />;
}
