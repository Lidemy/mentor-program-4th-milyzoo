import { SET_CURRENT_FILTER } from "../actionTypes";

const initialState = "all";

export default function filterReducer(state = initialState, action) {
  switch (action.type) {
    case SET_CURRENT_FILTER: {
      return action.payload.filterName;
    }

    default: {
      return state;
    }
  }
}
