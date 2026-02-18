import { Select } from './Select';

export const selectify = (element) => {
    if (element == null) return;
    element.selectify = new Select(element);    
}