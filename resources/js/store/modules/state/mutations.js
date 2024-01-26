import * as types from '../../mutation-types'

export default {
    [types.BRIDGE_DATA](state, server) {
        state.data = server
    }
}
