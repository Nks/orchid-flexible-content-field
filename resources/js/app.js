import FieldsFlexibleContent from "./controllers/fields/flexible_content_controller"

//We can work with this only when we already have an application
if (typeof window.application !== 'undefined') {
    window.application.register('fields--flexible_content', FieldsFlexibleContent)
}
