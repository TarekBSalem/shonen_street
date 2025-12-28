import type { Component, VNode } from 'vue'
import { ref } from 'vue'

const TOAST_LIMIT = 1
const TOAST_REMOVE_DELAY = 1000 // 1 second delay before removing from DOM

export type StringOrVNode = string | VNode | (() => VNode)

type ToasterToast = {
  id: string
  title?: string
  description?: StringOrVNode
  action?: Component
  open?: boolean
  onOpenChange?: (value: boolean) => void
  variant?: 'default' | 'destructive'
}

const actionTypes = {
  ADD_TOAST: 'ADD_TOAST',
  UPDATE_TOAST: 'UPDATE_TOAST',
  DISMISS_TOAST: 'DISMISS_TOAST',
  REMOVE_TOAST: 'REMOVE_TOAST',
} as const

let count = 0

function genId() {
  count = (count + 1) % Number.MAX_VALUE
  return count.toString()
}

const toasts = ref<ToasterToast[]>([])

function addToRemoveQueue(toastId: string) {
  if (toasts.value.find(t => t.id === toastId)?.open === false) {
    return
  }

  setTimeout(() => {
    toasts.value = toasts.value.filter(t => t.id !== toastId)
  }, TOAST_REMOVE_DELAY)
}

function toast(props: Omit<ToasterToast, 'id' | 'open' | 'onOpenChange'>) {
  const id = genId()

  const update = (props: ToasterToast) => {
    toasts.value = toasts.value.map(t => t.id === id ? { ...t, ...props } : t)
  }

  const dismiss = () => {
    toasts.value = toasts.value.map(t => t.id === id ? { ...t, open: false } : t)
    addToRemoveQueue(id)
  }

  toasts.value = [
    ...toasts.value,
    {
      ...props,
      id,
      open: true,
      onOpenChange: (open: boolean) => {
        if (!open)
          dismiss()
      },
    },
  ]

  return {
    id,
    dismiss,
    update,
  }
}

function useToast() {
  return {
    toast,
    toasts,
    dismiss: (toastId?: string) => {
      if (toastId) {
        toasts.value = toasts.value.map(t => t.id === toastId ? { ...t, open: false } : t)
        addToRemoveQueue(toastId)
      }
      else {
        toasts.value.forEach((t) => {
          addToRemoveQueue(t.id)
        })

        toasts.value = toasts.value.map(t => ({
          ...t,
          open: false,
        }))
      }
    },
  }
}

export { toast, useToast }

