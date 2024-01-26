import * as mutations from '../../mutation-types'
import * as actions from '../../action-types'
import users from '../../../api/users'

export default {
    [actions.BRIDGE_DATA](context, payload) {
        context.commit(mutations.BRIDGE_DATA, payload)
    }
}
